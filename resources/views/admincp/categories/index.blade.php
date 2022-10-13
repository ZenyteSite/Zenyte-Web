@include('layout.head')

<body style="overflow-x:hidden;">
@include('layout.navigation.mobile-nav')
<div id="modal-wrapper">
    @include('layout.navigation.topbar')
    @include('layout.navigation.navbar')
    @include('layout.header-content')
</div>
<div class="content" id="main-content">
    <div class="container" style="width:95%;">
        <div class="row">
            <div class="col s12 xl12">
                <div class="card">
                    <div class="card-content">
                        <div class="row" style="margin: 0;">
                            <h5 class="left category-title">Admin Control Panel - Category Control Panel</h5>
                            <a class="btn custom-btn right skill-dropdown" style="width:350px" href="{{ route('admincp.categories.create') }}">
                                Add New Category
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @include('layout.sidebar.admincp_sidebar')
            <div class="col s12 xl9">
                <div class="card">
                    <table class="responsive-table striped">
                        <thead>
                        <tr>
                            <th style="width:25%;">Category Name</th>
                            <th style="width:25%;">Products In Category</th>
                            <th style="width:25%;">Edit</th>
                            <th style="width:25%;">Delete</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $category)
                            <tr>
                               <td style="width:25%;">
                                    {{ $category->title }}
                                </td>
                               <td style="width:25%;">
                                    {{ $category->products->count() }}
                                </td>
                               <td style="width:25%;">
                                    <a href="{{ route('admincp.categories.edit', $category->id) }}"><i class="material-icons">edit</i></a>
                               </td>
                                <td style="width:25%;">
                                    <a href="{{ route('admincp.categories.delete', $category->id) }}"><i class="material-icons">delete</i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
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