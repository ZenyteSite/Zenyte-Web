@include('layout.head')

<body style="overflow-x:hidden;">
@include('layout.navigation.mobile-nav')
<div id="modal-wrapper">
    @include('layout.navigation.topbar')
    @include('layout.navigation.navbar')
    @include('layout.header-content')
</div>
<div class="content" id="main-content">
    <div class="container" style="width:95%;text-align: center">
        <div class="row">
            <div class="col s12 xl12">
                <div class="card">
                    <div class="card-content">
                        <div class="row" style="margin: 0;">
                            <h5 class="left category-title">Admin Control Panel - Products Control Panel</h5>
                            <a class="btn custom-btn right skill-dropdown" style="width:350px" href="{{ route('admincp.products.create') }}">
                                Add New Product
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @include('layout.sidebar.admincp_sidebar')
            <div class="col s12 xl9">
                <form action="{{ route('admincp.products') }}" method="post">
                    @csrf
                    <div class="input-field">
                        <input type="text" id="name" name="search" placeholder="Search by product name"><i class="material-icons hide-on-med-and-down">search</i>
                    </div>
                </form>
                <div class="card">
                    <table class="responsive-table striped">
                        <thead>
                        <tr>
                            <th style="width:10%;text-align: center"></th>
                            <th style="width:15%;text-align: center">Item Name</th>
                            <th style="width:5%;text-align: center">Amount</th>
                            <th style="width:10%;text-align: center">Category</th>
                            <th style="width:10%;text-align: center">Price</th>
                            <th style="width:15%;text-align: center">Created</th>
                            <th style="width:15%;text-align: center">Updated</th>
                            <th style="width:3%;text-align: center">Change Visibility</th>
                            <th style="width:3%;text-align: center">Edit</th>
                            <th style="width:3%;text-align: center">Delete</th>
                            <th style="width:3%;text-align: center">Feature</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $key => $product)
                            <tr>
                               <td style="width:10%;text-align: center">
                                    <img src="{{ $product->getThumbnailImage() }}" height="50px">
                                </td>
                               <td style="width:15%;text-align: center">
                                    {{ $product->item_name }}
                                </td>
                               <td style="width:5%;text-align: center">
                                    {{ $product->item_amount }}
                                </td>
                               <td style="width:10%;text-align: center">
                                    {{ $product->category->title }}
                                </td>
                                <td style="width:10%;text-align: center">
                                    @if($product->item_discount > 0)
                                        <span style="text-decoration: line-through;" class="red-text text-darken-4">{{ $product->item_price }}</span>
                                    @endif
                                    {{ $product->getDiscountedPrice() }}
                                </td>
                                <td style="width:15%;text-align: center">
                                    {{ Carbon\Carbon::parse($product->created_at)->toDayDateTimeString() }}
                                </td>
                                <td style="width:15%;text-align: center">
                                    {{ Carbon\Carbon::parse($product->updated_at)->toDayDateTimeString() }}
                                </td>
                                <td style="width:3%;text-align: center">
                                    <a href="{{ route('admincp.products.setVisibility', $product->id) }}" class="tooltipped" data-tooltip="{{  ($product->visible) ? 'Hide' : 'Show' }}">{!! ($product->visible) ? '<i class="fas fa-eye-slash"></i>' : '<i class="fas fa-eye"></i>' !!}</a>
                                </td>
                               <td style="width:3%;text-align: center">
                                    <a href="{{ route('admincp.products.edit', $product->id) }}"><i class="material-icons">edit</i></a>
                               </td>
                                <td style="width:3%;text-align: center">
                                    <a href="{{ route('admincp.products.delete', $product->id) }}"><i class="material-icons">delete</i></a>
                                </td>
                                <td style="width:3%;text-align: center">
                                    <a href="{{ route('admincp.products.setFeatured', $product->id) }}" class="tooltipped" data-tooltip="{{  ($product->is_featured) ? 'Remove From Featured' : 'Feature Product' }}">{!! ($product->is_featured) ? '<i class="far fa-star"></i>' : '<i class="fas fa-star"></i>' !!}</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@include('layout.scripts')
</body>
@include('layout.footer')
</html>