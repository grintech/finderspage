<div class="collapse navbar-collapse" id="sidenav-collapse-main">
    <ul class="navbar-nav">
        <li class="nav-item">
            <?php $active = strpos(request()->route()->getAction()['as'], 'admin.dashboard') > -1; ?>
            <a class="nav-link <?php echo $active ? ' active' : '' ?>" href="<?php echo route('admin.dashboard') ?>">
                <i class=" fas fa-th-large text-primary"></i>
                <span class="nav-link-text">Dashboard</span>
            </a>
        </li>

        <?php $active = strpos(request()->route()->getAction()['as'], 'user.users') > -1; ?>
        <li class="nav-item">
            <a class="nav-link <?php echo ($active ? ' active' : '') ?>" href="#usersmenue" data-toggle="collapse">
                <i class="fas fa-user text-primary"></i>
                <span class="nav-link-text">Manage Users</span>
            </a>
            <ul class="list-unstyled submenu collapse <?php echo ($active ? ' show' : '') ?>" id="usersmenue">
                <li class="nav-item">
                    <a class="nav-link <?php echo ($active ? ' active' : '') ?>" href="<?php echo route('user.users') ?>">
                        <span class="badge badge-dot mr-4">
                            <i class="bg-yellow"></i>
                            <span class="status">Users</span>
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($active ? ' active' : '') ?>" href="<?php echo route('user.users.add') ?>">
                        <span class="badge badge-dot mr-4">
                            <i class="bg-yellow"></i>
                            <span class="status">New users</span>
                        </span>
                    </a>
                </li>
            </ul>            
        </li>

        <?php if(Permissions::hasPermission('blogs', 'listing') || Permissions::hasPermission('blog_categories', 'listing')): ?>
        <?php $active = strpos(request()->route()->getAction()['as'], 'admin.blog') > -1; ?>
        <li class="nav-item">
            <a class="nav-link <?php echo ($active ? ' active' : '') ?>" href="#submenu_blogs" data-toggle="collapse" data-target="#submenu_blogs"
                    aria-expanded="false" aria-controls="submenu_blogs">
                <i class="fas fa-file-signature text-primary"></i>
                <span class="nav-link-text">Manage Posts</span>
            </a>
            <ul class="list-unstyled submenu collapse <?php echo ($active ? ' show' : '') ?>" id="submenu_blogs">
                <?php $active = strpos(request()->route()->getAction()['as'], 'admin.blogs.categories') > -1;?>
                <?php if(Permissions::hasPermission('blogs', 'listing')): ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo (!$active ? ' active' : '') ?>" href="<?php echo route('admin.blogs') ?>">
                        <span class="badge badge-dot mr-4">
                            <i class="bg-yellow"></i>
                            <span class="status">All Posts</span>
                        </span>
                    </a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link collapse <//?php echo ($active ? ' active' : '') ?>" href="#newPost" data-toggle="collapse" data-target="#newPost"
                            aria-expanded="true" aria-controls="newPost">
                        <span class="badge badge-dot mr-4">
                            <i class="bg-yellow"></i>
                            <span class="status">Create New Post</span>
                        </span>
                    </a> -->
                    <!-- <ul class="list-unstyled submenu collapse <//?php echo ($active ? ' show' : '') ?>" id="newPost">
                        <li class="nav-item">
                            <a class="nav-link <//?php echo ($active ? ' active' : '') ?>" href="<//?php echo route('admin.blogs.add') ?>">
                                <span class="badge badge-dot mr-4">
                                    <i class="bg-yellow"></i>
                                    <span class="status">Jobs</span>
                                </span>
                            </a>
                        </li> -->
                        <!-- <li class="nav-item">
                            <a class="nav-link <//?php echo ($active ? ' active' : '') ?>" href="{{route('realEstate_post')}}">
                                <span class="badge badge-dot mr-4">
                                    <i class="bg-yellow"></i>
                                    <span class="status">Real Estate</span>
                                </span>
                            </a>
                        </li> -->
                        <!-- <li class="nav-item">
                            <a class="nav-link <//?php echo ($active ? ' active' : '') ?>" href="sdfsdfsdfsdf">
                                <span class="badge badge-dot mr-4">
                                    <i class="bg-yellow"></i>
                                    <span class="status">Our Community</span>
                                </span>
                            </a>
                        </li> -->
                        <!-- <li class="nav-item">
                            <a class="nav-link <//?php echo ($active ? ' active' : '') ?>" href="{{route('admin.shopping')}}">
                                <span class="badge badge-dot mr-4">
                                    <i class="bg-yellow"></i>
                                    <span class="status">Shopping</span>
                                </span>
                            </a>
                        </li> -->
                        <!-- <li class="nav-item">
                            <a class="nav-link <//?php echo ($active ? ' active' : '') ?>" href="<//?php echo route('admin.service') ?>">
                                <span class="badge badge-dot mr-4">
                                    <i class="bg-yellow"></i>
                                    <span class="status">Services</span>
                                </span>
                            </a>
                        </li> -->
                        <!-- <li class="nav-item">
                            <a class="nav-link <//?php echo ($active ? ' active' : '') ?>" href="<//?php echo route('event_post') ?>">
                                <span class="badge badge-dot mr-4">
                                    <i class="bg-yellow"></i>
                                    <span class="status">Event</span>
                                </span>
                            </a>
                        </li> -->
                    <!-- </ul>            
                </li> -->

                <?php endif; ?>

                <?php if(Permissions::hasPermission('blog_categories', 'listing')): ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($active ? ' active' : '') ?>" href="<?php echo route('admin.blogs.categories') ?>">
                        <span class="badge badge-dot mr-4">
                            <i class="bg-yellow"></i>
                            <span class="status">Categories</span>
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($active ? ' active' : '') ?>" href="<?php echo route('admin.blogs.categories.add') ?>">
                        <span class="badge badge-dot mr-4">
                            <i class="bg-yellow"></i>
                            <span class="status">New Categories</span>
                        </span>
                    </a>
                </li>
                <?php endif; ?>
            </ul>            
        </li>

        <?php endif; ?>

        <?php if(Permissions::hasPermission('business', 'listing')): ?>
        <?php $active = strpos(request()->route()->getAction()['as'], 'business') > -1; ?>
        <li class="nav-item">
            <a class="nav-link <?php echo ($active ? ' active' : '') ?>" href="#featured_post" data-toggle="collapse" data-target="#featured_post"
                    aria-expanded="false" aria-controls="featured_post">
                <i class="fas fa-user text-primary"></i>
                <span class="nav-link-text">User Business Page</span>
            </a>
            <ul class="list-unstyled submenu collapse <?php echo ($active ? ' show' : '') ?>" id="featured_post">
                <li class="nav-item">
                    <a class="nav-link <?php echo ($active ? ' active' : '') ?>" href="{{route('admin.business.list')}}">
                        <span class="badge badge-dot mr-4">
                            <i class="bg-yellow"></i>
                            <span class="status">Business List</span>
                        </span>
                    </a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link <?php echo ($active ? ' active' : '') ?>" href="#">
                        <span class="badge badge-dot mr-4">
                            <i class="bg-yellow"></i>
                            <span class="status">Add Post</span>
                        </span>
                    </a>
                </li> -->
            </ul>            
        </li>
        <?php endif; ?>

        <?php if(Permissions::hasPermission('pages', 'listing') || Permissions::hasPermission('aboutus', 'listing')): ?>
        <?php $active = strpos(request()->route()->getAction()['as'], 'admin.pages') > -1 || strpos(request()->route()->getAction()['as'], 'admin.homeSettings') > -1 || strpos(request()->route()->getAction()['as'], 'admin.settings.aboutus') > -1 || strpos(request()->route()->getAction()['as'], 'admin.settings.about.brenda') > -1 || strpos(request()->route()->getAction()['as'], 'term-of-use.add') > -1; ?>

        <li class="nav-item">
            <a class="nav-link <?php echo ($active ? ' active' : '') ?>" href="#pages" data-toggle="collapse">
                <i class="fas fa-file-alt text-primary"></i> 
                <span class="nav-link-text">Pages</span>
            </a>
            <ul class="list-unstyled submenu collapse <?php echo ($active ? ' show' : '') ?>" id="pages">
                <?php if(Permissions::hasPermission('homeSettings', 'listing')): ?>
                <?php $active = strpos(request()->route()->getAction()['as'], 'admin.homeSettings') > -1; ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo $active ? ' active' : '' ?>" href="<?php echo route('admin.homeSettings') ?>">
                        <!-- <i class="far fa-info-circle text-primary"></i>    
                        <span class="nav-link-text">Home Page</span> -->
                        <span class="badge badge-dot mr-4">
                            <i class="bg-yellow"></i>
                            <span class="status">Home Page</span>
                        </span>
                    </a>
                </li>
                <?php endif; ?>

                <?php if(Permissions::hasPermission('aboutus', 'listing')): ?>
                <?php $active = strpos(request()->route()->getAction()['as'], 'admin.settings.aboutus') > -1; ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo $active ? ' active' : '' ?>" href="<?php echo route('admin.settings.aboutus') ?>">
                        <!-- <i class="far fa-info-circle text-primary"></i>    
                        <span class="nav-link-text">About Us</span> -->
                        <span class="badge badge-dot mr-4">
                            <i class="bg-yellow"></i>
                            <span class="status">About Us</span>
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $active ? ' active' : '' ?>" href="<?php echo route('admin.settings.about.brenda') ?>">
                        <!-- <i class="far fa-info-circle text-primary"></i>  
                        <i class="bg-yellow"></i> 
                        <span class="nav-link-text">About Admin</span> -->
                        <span class="badge badge-dot mr-4">
                            <i class="bg-yellow"></i>
                            <span class="status">About Admin</span>
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $active ? ' active' : '' ?>" href="<?php echo route('term-of-use.add') ?>">
                        <span class="badge badge-dot mr-4">
                            <i class="bg-yellow"></i>
                            <span class="status">Term & Policies</span>
                        </span>
                    </a>
                </li>
                <?php endif; ?>
            </ul>            
        </li>
        <?php endif; ?>

        <?php if(Permissions::hasPermission('newsletters', 'listing')): ?>
        <?php $active = strpos(request()->route()->getAction()['as'], 'admin.newsletter') > -1; ?>
        <li class="nav-item">
            <a class="nav-link <?php echo $active ? ' active' : '' ?>" href="<?php echo route('admin.newsletter') ?>">
                <i class="fas fa-envelope text-primary"></i>
                <span class="nav-link-text">Newsletter Subscribers</span>
            </a>
        </li>

        <?php endif; ?>

        <?php if(Permissions::hasPermission('feedbacks', 'listing')): ?>
        <?php $active = strpos(request()->route()->getAction()['as'], 'admin.feedback') > -1; ?>
        <li class="nav-item">
            <a class="nav-link <?php echo $active ? ' active' : '' ?>" href="<?php echo route('admin.feedback') ?>">
                <i class="fas fa-comment-alt-dots text-primary"></i>
                <span class="nav-link-text">Feedbacks</span>
            </a>
        </li>
        <?php endif; ?>

        <?php if(Permissions::hasPermission('contactus', 'listing')): ?>
        <?php $active = strpos(request()->route()->getAction()['as'], 'admin.contactus') > -1; ?>
        <li class="nav-item">
            <a class="nav-link <?php echo $active ? ' active' : '' ?>" href="<?php echo route('admin.contactus') ?>">
                <i class="fas fa-address-book text-primary"></i>
                <span class="nav-link-text">Contact us</span>
            </a>
        </li>
        <?php endif; ?> 

        <?php if(Permissions::hasPermission('payment', 'listing')): ?>
        <?php $active = strpos(request()->route()->getAction()['as'], 'payment.post') > -1; ?>
        <li class="nav-item">
            <a class="nav-link <?php echo $active ? ' active' : '' ?>" href="<?php echo route('payment.post') ?>">
                <!-- <i class="fas fa-address-book text-primary"></i> -->
                <i class="far fa-credit-card text-primary"></i>
                <span class="nav-link-text">Payments</span>
            </a>
        </li> 
        <?php endif; ?>   

        <?php if(Permissions::hasPermission('subscription', 'list')): ?>
        <?php $active = strpos(request()->route()->getAction()['as'], 'sub-plan.list') > -1; ?>
        <li class="nav-item">
            <a class="nav-link <?php echo $active ? ' active' : '' ?>" href="<?php echo route('sub-plan.list') ?>">
                <!-- <i class="fas fa-address-book text-primary"></i> -->
                <i class="far fa-credit-card text-primary"></i>
                <span class="nav-link-text">Subscription plans</span>
            </a>
        </li> 
        <?php endif; ?>   

        <?php if(Permissions::hasPermission('admins', 'listing')): ?>
        <?php $active = strpos(request()->route()->getAction()['as'], 'admin.admins') > -1; ?>
        <li class="nav-item">
            <a class="nav-link <?php echo $active ? ' active' : '' ?>" href="{{route('admin.admins')}}">
                <!-- <i class="fas fa-address-book text-primary"></i> -->
                <i class="fas fa-user-group text-primary"></i>
                <span class="nav-link-text">Sub Admin</span>
            </a>
        </li>  
        <?php endif; ?> 

        <?php if(Permissions::hasPermission('admins', 'admin.support.ticket')): ?>
        <?php $active = strpos(request()->route()->getAction()['as'], 'admin.support.ticket') > -1; ?>
        <li class="nav-item">
            <a class="nav-link <?php echo $active ? ' active' : '' ?>" href="{{route('admin.support.ticket')}}">
                <!-- <i class="fas fa-address-book text-primary"></i> -->
                <i class="fas fa-ticket text-primary"></i>
                <span class="nav-link-text">Support</span>
            </a>
        </li>  
        <?php endif; ?> 

        <?php if(Permissions::hasPermission('admins', 'video.list')): ?>
        <?php $active = strpos(request()->route()->getAction()['as'], 'video.list') > -1; ?>
        <li class="nav-item">
            <a class="nav-link <?php echo $active ? ' active' : '' ?>" href="{{route('video.list')}}">
                <!-- <i class="fas fa-address-book text-primary"></i> -->
                <i class="fas fa-film text-primary"></i>
                <span class="nav-link-text">Video List</span>
            </a>
        </li>  
        <?php endif; ?> 

        <?php if(Permissions::hasPermission('blog_post_list', 'listing')): ?>
        <?php $active = strpos(request()->route()->getAction()['as'], 'blog_post_list') > -1; ?>
        <li class="nav-item">
            <a class="nav-link <?php echo $active ? ' active' : '' ?>" href="{{route('blog_post_list')}}">
                <!-- <i class="far fa-cogs text-primary"></i> -->
                <i class="fas fa-blog text-primary"></i>
                <span class="nav-link-text">Blogs</span>
            </a>
        </li>
        <?php endif; ?> 

        <?php if(Permissions::hasPermission('admin.rep.post', 'listing')): ?>
        <?php $active = strpos(request()->route()->getAction()['as'], 'admin.rep.post') > -1; ?>
        <li class="nav-item">
            <a class="nav-link <?php echo $active ? ' active' : '' ?>" href="{{route('admin.rep.post')}}">
                <i class="far fa-cogs text-primary"></i>
                <span class="nav-link-text">Reported Post</span>
            </a>
        </li>
       <?php endif; ?>


       <?php if(Permissions::hasPermission('admin.reviews', 'listing')): ?>
        <?php $active = strpos(request()->route()->getAction()['as'], 'admin.reviews') > -1; ?>
        <li class="nav-item">
            <a class="nav-link <?php echo $active ? ' active' : '' ?>" href="{{route('admin.reviews')}}">
                <i class="far fa-cogs text-primary"></i>
                <span class="nav-link-text">Reviews</span>
            </a>
        </li>
       <?php endif; ?>
    </ul>

    <!-- Divider -->

    <hr class="my-3">

    <?php if(AdminAuth::isAdmin()): ?>
    <!-- Heading -->
    <h6 class="navbar-heading p-0 text-muted">
        <span class="docs-normal">Others</span>
    </h6>
    <?php endif; ?>

    <!-- Navigation -->

    <ul class="navbar-nav mb-md-3">
        <?php if(AdminAuth::isAdmin()): ?>
        <?php $active = strpos(request()->route()->getAction()['as'], 'admin.emailTemplates') > -1; ?>
        <li class="nav-item">
            <a class="nav-link <?php echo $active ? ' active' : '' ?>" href="<?php echo route('admin.emailTemplates') ?>">
                <i class="ni ni-email-83 text-primary"></i>
                <span class="nav-link-text">Email Templates</span>
            </a>
        </li>

        <?php $active = strpos(request()->route()->getAction()['as'], 'admin.activities') > -1; ?>
        <li class="nav-item">
            <a class="nav-link <?php echo $active ? ' active' : '' ?>" href="<?php echo route('admin.activities.emails') ?>">
                <i class="ni ni-bullet-list-67 text-primary"></i>
                <span class="nav-link-text">Email Logs</span>
            </a>
        </li>

        <?php $settings = strpos(request()->route()->getAction()['as'], 'admin.settings') > -1; ?>
        <?php

            if(isset($settings) && $settings)

            {

                $active = $settings;

            }

            else

            {

                $active = '';

            }

        ?>

        <li class="nav-item">
            <a class="nav-link <?php echo $active ? ' active' : '' ?>" href="<?php echo route('admin.settings') ?>">
                <i class="far fa-cogs text-primary"></i>
                <span class="nav-link-text">Settings</span>
            </a>
        </li>

        <?php endif; ?>
    </ul>
</div>