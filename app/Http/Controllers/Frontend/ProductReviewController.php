<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductReview;
use App\Models\UserAuth;
use App\Models\Blogs;
use App\Models\Business;
use App\Models\Admin\Users;
use App\Libraries\General;
use App\Models\Admin\Notification;
use Requests;

class ProductReviewController extends Controller
{
    public function store(Request $request)
    {
        // dd($request->all());
        $userData = UserAuth::getLoginUser();
        $to_user = Users::select('username')->where('id', $request->blog_user_id)->first();
        $reviewExists = ProductReview::where('user_id', $userData->id)
                                     ->where('product_id', $request->product_id)
                                     ->where('type', $request->type)
                                     ->first();

        if (!$reviewExists) {
            $productReview = new ProductReview();
            $result = $productReview->saveProductReview($request);

            if ($result === true) {
                $codes = [
                    '{first_name}' => $request->name,
                    '{url}' => $request->url,
                    '{review_text}' => $request->description,
                ];

                General::sendTemplateEmail($request->email, 'Review-product', $codes);

                $notice1 = [
                    'from_id' => UserAuth::getLoginId(),
                    'to_id' => $request->blog_user_id,
                    'type' => 'post',
                    'cate_id' => 6,
                    'rel_id' => $request->product_id,
                    'url' => $request->url,
                    'message' => $userData->first_name . ' submitted a review on your product.',
                ];

                $notice2 = [
                    'from_id' => UserAuth::getLoginId(),
                    'to_id' => 7,
                    'type' => 'post',
                    'cate_id' => 6,
                    'rel_id' => $request->product_id,
                    'url' => $request->url,
                    'message' => $userData->first_name . ' submitted a review on ' . $to_user->username . ' product.',
                ];

                foreach ([$notice1, $notice2] as $notice) {
                    Notification::create($notice);
                }

                $filter_data = ProductReview::where('type', $request->type)->latest()->first();

                return response()->json(['success' => 'Thank you for your feedback.'], 200);
            } else {
                return response()->json(['error' => 'Something went wrong.'], 500);
            }
        } else {
            return response()->json(['error' => 'You have already submitted a review for this product.'], 400);
        }
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $productReview = new ProductReview();
        $updateReview = $productReview->updateProductReview($request, $id);
    
        if ($updateReview === true) {
            $reportedUser = ProductReview::where('id', $id)->value('user_id');
            $rel_id = ProductReview::where('id', $id)->value('product_id');
    
            $url = route('blog.admin.review', ['id' => $rel_id]);
    
            $toUser = Users::select('username')->where('id', $reportedUser)->first();
            $userData = UserAuth::getLoginUser();
    
            $productUserId = Blogs::select('user_id')->where('id', $rel_id)->first();
            $productUser = Users::select('username')->where('id', $productUserId->user_id)->first();
    
            $notice = [
                'from_id' => UserAuth::getLoginId(),
                'to_id' => 7,
                'type' => 'post',
                'cate_id' => 6,
                'rel_id' => $rel_id,
                'url' => $url,
                'message' => $userData->first_name . ' updated their report on ' . $toUser->username . '\'s review of a ' . $productUser->username . ' product.',
            ];
    
            Notification::create($notice);
    
            return response()->json([
                'success' => true,
                'message' => 'Report updated successfully.'
            ], 200);
        } else {
            return response()->json([
                'error' => true,
                'message' => 'An error occurred while updating the report. Please try again.'
            ], 500);
        }
    }
    

    public function add(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'report' => 'required|array',
            'user_id' => 'required|integer',
        ]);
    
        // Check if the report is empty
        if (empty($request->report)) {
            return response()->json([
                'error' => true,
                'message' => 'The report cannot be empty.'
            ], 400); // Set HTTP status code to 400 Bad Request
        }
    
        // Encode the report data to JSON
        $reportData = [
            'report' => $request->report,
            'user_id' => $request->user_id,
        ];
        $reportJson = json_encode($reportData);
    
        // Check if the report already exists
        $existingReport = ProductReview::where('id', $id)->value('report');
    
        if ($existingReport) {
            $existingReportData = json_decode($existingReport, true);
            
            // Check if report already submitted
            if (!empty($existingReportData['report']) && $existingReportData['user_id'] == $request->user_id) {
                return response()->json([
                    'error' => true,
                    'message' => 'You have already reported this review.'
                ], 400); // Set HTTP status code to 400 Bad Request
            }
        }
    
        // Update the report
        $productReport = ProductReview::where('id', $id)->update(['report' => $reportJson]);
    
        $reportedUser = ProductReview::where('id', $id)->value('user_id');
        $rel_id = ProductReview::where('id', $id)->value('product_id');
    
        $url = route('blog.admin.review', ['id' => $rel_id]);
    
        $toUser = Users::select('username')->where('id', $reportedUser)->first();
        $userData = UserAuth::getLoginUser();
    
        $productUserId = Blogs::select('user_id')->where('id', $rel_id)->first();
    
        $productUser = Users::select('username')->where('id', $productUserId->user_id)->first();
    
        $notice = [
            'from_id' => UserAuth::getLoginId(),
            'to_id' => 7,
            'type' => 'post',
            'cate_id' => 6,
            'rel_id' => $rel_id,
            'url' => $url,
            'message' => $userData->first_name . ' reports on ' . $toUser->username . '\'s review of a ' . $productUser->username . ' product.',
        ];
    
        Notification::create($notice);
    
        // Check if the update was successful
        if ($productReport) {
            return response()->json([
                'success' => true,
                'message' => 'Report submitted successfully.'
            ]);
        } else {
            return response()->json([
                'error' => true,
                'message' => 'An error occurred while submitting the report. Please try again.'
            ], 500); // Optionally set HTTP status code to 500 Internal Server Error if appropriate
        }
    }

    public function destroy($review_id)
    {
        $review = ProductReview::find($review_id);
    
        if ($review) {
            $review->delete();
            return response()->json(['success' => 'Review has been deleted.'], 200);
        } else {
            return response()->json(['error' => 'Review not found.'], 404);
        }
    }    


    public function store_business_review(Request $request)
    {
        // dd($request->all());
        $userData = UserAuth::getLoginUser();
        $to_user = Users::select('username')->where('id', $request->blog_user_id)->first();
        $reviewExists = ProductReview::where('user_id', $userData->id)
                                     ->where('product_id', $request->product_id)
                                     ->where('type', $request->type)
                                     ->first();

        if (!$reviewExists) {
            $productReview = new ProductReview();
            $result = $productReview->saveProductReview($request);

            if ($result === true) {
                $codes = [
                    '{first_name}' => $request->name,
                    '{url}' => $request->url,
                    '{review_text}' => $request->description,
                ];

                General::sendTemplateEmail($request->email, 'Review-product', $codes);

                $notice1 = [
                    'from_id' => UserAuth::getLoginId(),
                    'to_id' => $request->blog_user_id,
                    'type' => 'post',
                    'cate_id' => 1,
                    'rel_id' => $request->product_id,
                    'url' => $request->url,
                    'message' => $userData->first_name . ' submitted a review on your business post.',
                ];

                $notice2 = [
                    'from_id' => UserAuth::getLoginId(),
                    'to_id' => 7,
                    'type' => 'post',
                    'cate_id' => 1,
                    'rel_id' => $request->product_id,
                    'url' => $request->url,
                    'message' => $userData->first_name . ' submitted a review on ' . $to_user->username . ' business post.',
                ];

                foreach ([$notice1, $notice2] as $notice) {
                    Notification::create($notice);
                }

                $user = Users::find(UserAuth::getLoginId());
                $business = Business::where('id', $request->product_id)->first();

                $filter_data = ProductReview::where('product_id', $request->product_id)
                                            ->where('type', $request->type)
                                            ->where('user_id', UserAuth::getLoginId())
                                            ->get();

                $html = view('frontend.reviews.create_business', compact('filter_data', 'user', 'business'))->render();
                return response()->json(['html' => $html,
                                        'success' => 'Thank you for your feedback.'], 200);
                // return response()->json(['success' => 'Thank you for your feedback.'], 200);
            } else {
                return response()->json(['error' => 'Something went wrong.'], 500);
            }
        } else {
            return response()->json(['error' => 'You have already submitted a review for this product.'], 400);
        }
    }

    public function update_business_review(Request $request, $id)
    {
        // dd($request->files);
        $postReview = new ProductReview();
        $updateReview = $postReview->updateProductReview($request, $id);
    
        if ($updateReview === true) {
            $reportedUser = ProductReview::where('id', $id)->value('user_id');
            $rel_id = ProductReview::where('id', $id)->value('product_id');
    
            $url = route('business_page.front.single.listing', ['slug' => $request->slug]);
    
            $toUser = Users::select('username')->where('id', $reportedUser)->first();
            $userData = UserAuth::getLoginUser();
    
            $productUserId = Business::select('user_id')->where('id', $rel_id)->first();
            $productUser = Users::select('username')->where('id', $productUserId->user_id)->first();
    
            $notice = [
                'from_id' => UserAuth::getLoginId(),
                'to_id' => 7,
                'type' => 'post',
                'cate_id' => 1,
                'rel_id' => $rel_id,
                'url' => $url,
                'message' => $userData->first_name . ' updated their review on ' . $productUser->username . ' business post.',
            ];
    
            Notification::create($notice);
    
            // $user = Users::find(UserAuth::getLoginId());

            $business = Business::where('id', $request->product_id)->first();

            $filter_data = ProductReview::where('product_id', $request->product_id)
                                        ->where('type', $request->type)
                                        ->with('user')
                                        ->get();

            $html = view('frontend.reviews.edit_business', compact('filter_data', 'business'))->render();
            return response()->json(['html' => $html,
                                    'success' => true,
                'message' => 'Review updated successfully.'
            ], 200);
        } else {
            return response()->json([
                'error' => true,
                'message' => 'An error occurred while updating the review. Please try again.'
            ], 500);
        }
    }

    public function deleteFile(Request $request)
    {
        $review = ProductReview::find($request->id);
        $files = json_decode($review->files);

        if (($key = array_search($request->file, $files)) !== false) {
            unset($files[$key]);
            unlink(public_path('images_reviews/' . $request->file));
        }

        $review->files = json_encode(array_values($files));
        $review->save();

        return response()->json(['success' => 'File removed successfully.']);
    }

}
