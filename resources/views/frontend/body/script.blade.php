 {{-- /// Start Wishlist Add Option // --}}
 <script type="text/javascript">

    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
    })

    function addToWishList(course_id){

        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "/add-to-wishlist/"+course_id,

            success:function(data){

                  // Start Message

            const Toast = Swal.mixin({
                  toast: true,
                  position: 'top-end',
                  showConfirmButton: false,
                  timer: 1000
            })
            if ($.isEmptyObject(data.error)) {

                    Toast.fire({
                    type: 'success',
                    icon: 'success',
                    title: data.success,
                    })

            }else{

           Toast.fire({
                    type: 'error',
                    icon: 'error',
                    title: data.error,
                    })
                }

              // End Message

            }
        })

    }


 </script>
 {{-- /// End Wishlist Add Option // --}}
 {{-- {{ url('course/details/'.$course->id. '/' .$course->course_name_slug) }} --}}
  {{-- /// Start Load Wishlist Data // --}}
 <script type="text/javascript">

    function wishlist(){
        $.ajax({
            type: "GET",
            dataType: 'json',
            url: "/get-wishlist-course/",

            success:function(response){

                $('#wishQty').text(response.wishQty);

                var rows = ""
                $.each(response.wishlist, function(key, value){

            rows += `
                    <div class="col-lg-4 responsive-column-half">
            <div class="card card-item">
                <div class="card-image">
                    <a href="/course/details/${value.course.id}/${value.course.course_name_slug}" class="d-block">
                        <img class="card-img-top" src="/${value.course.course_image}" alt="Card image cap">
                    </a>

                </div><!-- end card-image -->



                <div class="card-body">
                    <h6 class="mb-3 ribbon ribbon-blue-bg fs-14">${value.course.label}</h6>
                    <h5 class="card-title"><a href="/course/details/${value.course.id}/${value.course.course_name_slug}">${value.course.course_name}</a></h5>

                    <div class="d-flex justify-content-between align-items-center">

                        ${value.course.discount_price == null
                        ?`<p class="text-black card-price font-weight-bold">Ksh. ${value.course.selling_price}</p>`
                        :`<p class="text-black card-price font-weight-bold">Ksh. ${value.course.discount_price} <span class="before-price font-weight-medium">Ksh. ${value.course.selling_price}</span></p>`
                        }

                        <div class="shadow-sm cursor-pointer icon-element icon-element-sm" data-toggle="tooltip" data-placement="top" title="Remove from Wishlist"  id="${value.id}" onclick="wishlistRemove(this.id)" ><i class="la la-heart"></i></div>
                    </div>
                </div>
            </div>
        </div>
             `
                });
               $('#wishlist').html(rows);

            }
        })
    }
    wishlist();
/// WishList Remove Start  //
function wishlistRemove(id){
        $.ajax({
            type: "GET",
            dataType: 'json',
            url: "/wishlist-remove/"+id,
            success:function(data){
             wishlist();
                 // Start Message
            const Toast = Swal.mixin({
                  toast: true,
                  position: 'top-end',
                  showConfirmButton: false,
                  timer: 1000
            })
            if ($.isEmptyObject(data.error)) {

                    Toast.fire({
                    type: 'success',
                    icon: 'success',
                    title: data.success,
                    })
            }else{

           Toast.fire({
                    type: 'error',
                    icon: 'error',
                    title: data.error,
                    })
                }
              // End Message
            }
        })
    }
    /// End WishList Remove //

 </script>
  {{-- /// End Load Wishlist Data // --}}

{{-- /// Start Add To Cart  // --}}
<script type="text/javascript">

    function addToCart(courseId, courseName, instructorId, slug){
         $.ajax({
             type: "POST",
             dataType: 'json',
             data: {
                 _token: '{{ csrf_token() }}',
                 course_name: courseName,
                 course_name_slug: slug,
                 instructor: instructorId
             },

             url: "/cart/data/store/"+ courseId,
             success: function(data) {

                miniCart();

                  // Start Message

             const Toast = Swal.mixin({
                   toast: true,
                   position: 'top-end',
                   showConfirmButton: false,
                   timer: 1000
             })
             if ($.isEmptyObject(data.error)) {

                     Toast.fire({
                     type: 'success',
                     icon: 'success',
                     title: data.success,
                     })

             }else{

            Toast.fire({
                     type: 'error',
                     icon: 'error',
                     title: data.error,
                     })
                 }

               // End Message
             }
         });
    }

 </script>
      {{-- /// End Add To Cart  // --}}


       {{-- /// Start Mini Cart  // --}}
  <script type="text/javascript">
    function miniCart(){
        $.ajax({
            type: 'GET',
            url: '/course/mini/cart',
            dataType: 'json',
            success:function(response){

                $('span[id="cartSubTotal"]').text(response.cartTotal);
                $('#cartQty').text(response.cartQty);

                var miniCart = ""




                $.each(response.carts, function(key,value){
                    miniCart += `<li class="media media-card">
                            <a href="shopping-cart.html" class="media-img">
                                <img src="/${value.options.image}" alt="Cart image">
                            </a>
                            <div class="media-body">
                                <h5><a href="/course/details/${value.id}/${value.options.slug}"> ${value.name}</a></h5>

                                 <span class="d-block fs-14">Ksh. ${value.price}</span>
                                 <a type="submit" id="${value.rowId}" onclick="miniCartRemove(this.id)"><i class="la la-times"></i></a>
                            </div>
                        </li>
                        `

                });
                $('#miniCart').html(miniCart);
            }
        })
    }
    miniCart();
    //Minicart remove course
    function miniCartRemove(rowId){
        $.ajax({
            type: 'GET',
            url: '/minicart/course/remove/'+rowId,
            dataType: 'json',
            success:function(data){
                miniCart();
               // Start Message

             const Toast = Swal.mixin({
                   toast: true,
                   position: 'top-end',
                   showConfirmButton: false,
                   timer: 1000
             })
             if ($.isEmptyObject(data.error)) {

                     Toast.fire({
                     type: 'success',
                     icon: 'success',
                     title: data.success,
                     })

             }else{

            Toast.fire({
                     type: 'error',
                     icon: 'error',
                     title: data.error,
                     })
                 }

               // End Message
            }

        })
    }
      </script>
      {{-- end Minicart --}}



      {{-- Start cart page script --}}
    <script type="text/javascript">
         function cart(){
            $.ajax({
                type: 'GET',
                url: '/get-cart-course',
                dataType: 'json',
                success:function(response){
                    var rows = ""
                    $.each(response.carts,function(key,value){

                        rows += '
                        <tr>
                    <th scope="row">
                        <div class="media media-card">
                            <a href="course-details.html" class="mr-0 media-img">
                                <img src="images/small-img.jpg" alt="Cart image">
                            </a>
                        </div>
                    </th>
                    <td>
                        <a href="course-details.html" class="text-black font-weight-semi-bold">The Complete Financial Analyst Course 2019</a>
                        <p class="fs-14 text-gray lh-20">By <a href="teacher-detail.html" class="text-color hover-underline">Mark Hardson</a>, Master Digital Marketing: Strategy, Social Media Marketing, SEO, YouTube, Email, Facebook Marketing, Analytics &amp; More!</p>
                    </td>
                    <td>
                        <ul class="generic-list-item font-weight-semi-bold">
                            <li class="text-black lh-18">$22.99</li>
                            <li class="before-price lh-18">$55.99</li>
                        </ul>
                    </td>
                    <td>
                        <div class="quantity-item d-flex align-items-center">
                            <button class="qtyBtn qtyDec"><i class="la la-minus"></i></button>
                            <input class="qtyInput" type="text" name="qty-input" value="1">
                            <button class="qtyBtn qtyInc"><i class="la la-plus"></i></button>
                        </div>
                    </td>
                    <td>
                        <button type="button" class="border-0 shadow-sm icon-element icon-element-xs" data-toggle="tooltip" data-placement="top" title="Remove">
                            <i class="la la-times"></i>
                        </button>
                    </td>
                </tr>
                '
                    });
                    $('#cartPage')

                }
            })
         }
    </script>
    {{-- End  cart page script --}}
