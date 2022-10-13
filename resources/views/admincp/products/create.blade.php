@include('layout.head')
<style>
    .CodeMirror {
        height: 200px!important;
        background-color:#0F0D0B!important;
        color:#c9aa71 !important;
    }
    .CodeMirror, .CodeMirror-scroll {
        min-height: 200px!important;
    }
</style>
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
                            <h5 class="left category-title">Admin Control Panel - Product Control Panel</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @include('layout.sidebar.admincp_sidebar')
            <div class="col s12 xl9">
                <div class="card">
                    <div class="card-content">
                    <form method="POST" action="{{ route('admincp.products.create') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="input-field" style="margin-bottom: 20px;">
                            <span>Item Name</span><br>
                            <small>The name of the item. This will appear on the storefront. An example could be 'Abyssal Whip'.</small>
                            <input class="input-field" type="text" name="item_name" required>
                        </div>
                        <div class="input-field" style="margin-bottom: 20px;">
                            <span>Item Amount</span><br>
                            <small>The amount of the item given when this item is ordered. If this was 50, this product being purchased once would result in 50 of this item being given in game.</small>
                            <input class="input-field" type="text" name="item_amount" required>
                        </div>
                        <div class="input-field" style="margin-bottom: 20px;">
                            <span>Item ID</span><br>
                            <small>The id of the item given in game.</small>
                            <input class="input-field" type="text" name="item_id" required>
                        </div>
                        <div class="input-field">
                            <span>Category:</span>
                            <select name="category">
                                @foreach($categories as $category)
                                    <option value="{{ $category->title }}">{{ $category->title }}</option>
                                    @endforeach
                            </select>
                        </div>
                        <div class="input-field" style="margin-bottom: 20px;">
                            <span>Item Price</span><br>
                            <small>The amount of credits required to purchase this product. This is before discount, so if you put 50 in this field and 10 in the discount field, the product would show as being worth 45 credits.</small>
                            <input class="input-field" type="text" name="item_price" required>
                        </div>
                        <div class="input-field" style="margin-bottom: 20px;">
                            <span>Item Discount (%)</span><br>
                            <small>The amount of discount to apply to this item. This is in %. If you do not wish to apply a discount to this item, simply leave this field blank.</small>
                            <input class="input-field" type="text" name="item_discount" max="99.9">
                        </div>
                        <p>
                            <input class="input-field" type="checkbox" id="ironman" name="ironman" value="1">
                            <label for="ironman">Can ironmen purchase this?</label>
                        </p>
                        <p>
                            <input class="input-field" type="checkbox" id="isbond" name="isbond" value="1">
                            <label for="isbond">Is this product a bond?</label>
                        </p>
                        <div class="input-field" id="bondAmount" style="margin-bottom: 20px;display:none;">
                            <span>How much should this bond take away from the users amount donated?</span><br>
                            <small>This is the amount that will be subtracted from the total users amount donated, when they purchase this bond from the store. Making this 0 will still make this product a bond. If you don't want this product to be a bond, simply untick the above checkbox.</small>
                            <input class="input-field" type="number" name="bond_amount" id="bond_amount">
                        </div>
                        <div class="input-field" style="margin-bottom: 20px;">
                            <span>Item Description</span><br>
                            <small>The description of this product that shows when you click to view the description. Markdown can be used here - <a target="_blank" href="https://markdown-it.github.io/">Demo</a></small>
                            <textarea name="item_description" id="item_description" class="input-field" rows="4">{{ old('description') }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col s6 xl6">
                                <small>This the image that will show on the product on the index of the store</small>
                                <div class="file-field input-field">
                                    <div class="btn">
                                        <span>Upload Thumbnail</span>
                                        <input type="file" name="thumbnailImage">
                                    </div>
                                    <div class="file-path-wrapper">
                                        <input class="file-path validate" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="col s6 xl6">
                                <small>These are the images that are shown when viewing the description of the store</small>
                                <div class="file-field input-field" style="display:block">
                                    <div class="btn">
                                        <span>Upload Description Image(s)</span>
                                        <input type="file" name="desc_images[]" multiple>
                                    </div>
                                    <div class="file-path-wrapper">
                                        <input class="file-path validate" type="text">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <button type="submit" class="btn custom-btn skill-dropdown">Save Changes</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@include('layout.scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
<script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
<script>
    $(function() {
        new SimpleMDE({
            element: $("#item_description")[0],
            spellChecker: false,
            showIcons: ["code", "table"],
        });
        $('#isbond').on('click', function() {
           showBondField();
        });
        function showBondField() {
            if(!$('#bond_amount').prop('required')) {
                $('#bondAmount').css('display', 'block');
                $('#bond_amount').prop('required', 'true');
            } else {
                $('#bondAmount').css('display', 'none');
                $('#bond_amount').removeAttr('required');
                $('#bond_amount').val('');
            }
        }
    });
</script>
</body>
@include('layout.footer')
</html>