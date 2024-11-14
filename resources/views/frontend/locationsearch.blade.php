<div class="top-search">
    <form id="searchForm" method="POST" action="{{ route('search') }}">
        <div class="row">
            @csrf
            <div class="col-md-12 coll-1 mb-2">
                <div class="select-job">
                    <select id="searcjob" class="form-select" name="searcjobParent">
                        <option value="">Categories</option>
                        @foreach($blog_categories as $cate)
                            @if ($cate->id !=727)
                                <option value="{{$cate->id}}">{{$cate->title}}</option>        
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-12 coll-1 mb-2">
                <div class="select-job">
                    <select id="searcjobChild" name="searcjobChild" class="form-select" data-live-search="true">
                        <option value="">Sub Categories</option>
                    </select>
                </div>
            </div>

            <div class="col-md-12 coll-1 mb-2">
                <div class="location-search">
                    <input type="text" name="location" class="form-control get_loc" id="get-Location" placeholder="Location">
                    <i id="getLocation" class="bi bi-geo-alt"></i>
                </div>
                <div class="searcRes" id="autocomplete-results"></div>
            </div>

            <div class="col-sm-12 col-md-12 coll-2 mb-2">
                <div class="search-fields">
                    <button class="btn fields-search" type="submit">Search<i class="bi bi-arrow-right"></i></button>
                </div>
            </div>
        </div>
    </form>
</div>


<script>
$(document).ready(function() {
    $('#searcjob').on('change', function() {
    let selectedParent = $(this).val();
    console.log(selectedParent);
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "{{ url('/getchildcat') }}",
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken
            },
            data: {
                selectedParent: selectedParent,    
            },
            success: function(response) {
                console.log('success', response);
                let optionsHtml = "<option value=''>Sub Categories</option>";
                $.each(response, function(index, item) {
                    // console.log('item', item);
                    optionsHtml += "<option data-id='" + item.parentID + "' data-sub_id='" + item.id + "' value='" + item.slug + "'>" + item.title + "</option>";
                });
                $('#searcjobChild').html(optionsHtml);
            },
            error: function(response) {
                console.log('error', response);
            }
        });
    });

    // $('#searcjobChild').on('change', function(e) {
    //     var slug = $(this).val();
    //     var id = $('option:selected', this).attr('data-id');
    //     var sub_id = $('option:selected', this).attr('data-sub_id');

    //     var headers = {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     };

    //     $.ajax({
    //         type: 'post',
    //         url: '{{ route("filter.data") }}',
    //         data: {
    //             slug: slug,
    //             id: id,
    //             sub_id: sub_id,
    //         },
    //         headers: headers,
    //         dataType: 'json',
    //         success: function(data) {
    //             console.log(data);
    //             $('.related-job').html(data.html);
    //         },
    //         error: function(xhr, status, error) {
    //             console.error('Error:', xhr.responseText);
    //         }
    //     });
    // });

    $('#searchForm').on('submit', function(e) {
        e.preventDefault();

        var searcjobParent = $('#searcjob').val();
        var searcjobChild = $('#searcjobChild option:selected', this).attr('data-sub_id');
        var location = $('#get-Location').val();

        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        };

        $.ajax({
            type: 'POST',
            url: "{{ route('getPostsByLocation') }}",
            data: {
                searcjobParent: searcjobParent,
                searcjobChild: searcjobChild,
                location: location,
            },
            headers: headers,
            dataType: 'json',
            success: function(data) {
                console.log(data);
                $('.related-job').html(data.html);
            },
            error: function(xhr, status, error) {
                console.error('Error:', xhr.responseText);
            }
        });
    });


//     $('.Uncategorized').on('click', function(e) {
//         e.preventDefault();
//         var csrfToken = $('meta[name="csrf-token"]').attr('content');
//         $.ajax({
//             type: 'post',
//             url: '{{ route("filter.data.uncategorized") }}',
//             headers: {
//                 'X-CSRF-TOKEN': csrfToken
//             },
//             success: function(data) {
//                 console.log(data);
//                 $('.related-job').html(data.html);
//             },
//             error: function(xhr, status, error) {
//                 console.error('Error:', xhr.responseText);
//             }
//         });
//     });

//     $('#searcjob').on('change', function(e) {
//         var id = $(this).val();
//         var csrfToken = $('meta[name="csrf-token"]').attr('content');
//         $.ajax({
//             type: 'post',
//             url: '{{ route("filter.data.category") }}',
//             data: { id: id },
//             headers: { 'X-CSRF-TOKEN': csrfToken },
//             dataType: 'json',
//             success: function(data) {
//                 console.log(data);
//                 $('.related-job').html(data.html);
//             },
//             error: function(xhr, status, error) {
//                 console.error('Error:', xhr.responseText);
//             }
//         });
//     });
});
</script>