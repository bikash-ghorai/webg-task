@extends('layouts')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col align-self-start">
                <h4>Product List</h4>
            </div>
            <div class="col align-self-center"></div>
            <div class="col align-self-end" style="text-align: right;">
                <button type="button" class="btn btn-primary" id="createProduct">Create Product</button>
            </div>
        </div>
    </div>
    <hr>
    <div class="container">
        <div class="row">
            <table id="productTable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Added By</th>
                        <th>Edit</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="products">
                    
                    
                </tbody>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Added By</th>
                        <th>Edit</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <br><br>
    <!-- Modal -->
<div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="productModalLabel">Add Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" id="addForm">
        <input type="hidden" name="proid" id="productId" value="">
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label>Product Name</label>
                    <input type="text" class="form-control" name="name" id="proName" >
                </div>
            </div>


            <div class="col-md-4">
                <div class="form-group">
                    <label>Price</label>
                    <input type="number" class="form-control" name="price" id="proPrice">
                </div>
          </div>

          <div class="col-md-12">
            <div class="form-group">
              <label>Description</label>
              <textarea class="form-control" rows="3" name="description" id="description"></textarea>
            </div>
          </div>

          <div class="col-md-12">
              <p class="error" id="errorAdd"></p>
          </div>
        </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="savePro">Save</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
@endsection
@section('custom_script')
<script type="text/javascript">
    var token = localStorage.getItem('token');
    var user_name = localStorage.getItem('user_name');
    $(document).ready(function(){
        
        if (token != null) {
            $("#navbarDropdown").html(user_name);
            $("#userSection").css('opacity', 1);
            $("#loginSection").css('opacity', 0);
            $.ajax({
                url: "{{ url('api/products') }}",
                headers: {'Authorization': 'Bearer '+token},
                success: function(response) {
                    console.log(response);
                    if (response.status == 'Success') {
                        var list = response.data;
                        for (var i = 0; i < list.length; i++) {
                            let html = '<tr>';
                            html += '<td>'+list[i].name+'</td>';
                            html += '<td>'+list[i].price+'</td>';
                            html += '<td>'+list[i].description+'</td>';
                            html += '<td>'+list[i].user_info.first_name+' '+list[i].user_info.last_name+'</td>';
                            html += '<td ><button type="button" class="btn btn-info" onclick="editProduct('+list[i].id+')">Edit</button></td>';
                            html += '<td><button type="button" class="btn btn-danger" onclick="deleteProduct('+list[i].id+')">Delete</button></td>';
                            html += '</tr>';
                            $("#products").append(html);
                        }
                        $('#productTable').DataTable();
                        $(".loader-bg").hide();
                    }else{
                        localStorage.removeItem('token');
                        window.location.href = '{{ url("login") }}';
                    }
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        }else{
            window.location.href = '{{ url("login") }}';
        }
    });
    $("#logout").click(function(){
        $.ajax({
            url: "{{ url('api/logout') }}",
            headers: {'Authorization': 'Bearer '+token},
            success: function(response) {
                if (response.status == 'Success') {
                    localStorage.removeItem('token');
                    window.location.href = '{{ url("login") }}';
                }
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    })
    $("#createProduct").click(function(){
        $("#productModal").modal('show');
    });
    $("#savePro").click(function(){
        var name = $("#proName").val();
        var price = $("#proPrice").val();
        var description = $("#description").val();
        var proid = $("#productId").val();
        if (name == '') {
            $("#proName").addClass('error-field');
            $("#errorAdd").text('Enter product name');
            $("#errorAdd").show();
        }else if (price == '') {
            $("#proPrice").addClass('error-field');
            $("#errorAdd").text('Enter product price');
            $("#errorAdd").show();
        }else if (description == '') {
            $("#description").addClass('error-field');
            $("#errorAdd").text('Enter product description');
            $("#errorAdd").show();
        }else{
            $.ajax({
                headers: {'Authorization': 'Bearer '+token},
                url: "{{ url('api/product-save') }}",
                method: 'POST',
                data: {proid: proid, name: name, price: price, description: description},
                success: function(response) {
                    if(response.status == 'Success'){
                        var product = response.data;
                        if(product == 1){
                            location.reload();
                        }else{
                            let html = '<tr>';
                                html += '<td>'+product.name+'</td>';
                                html += '<td>'+product.price+'</td>';
                                html += '<td>'+product.description+'</td>';
                                let user = product.userInfo;
                                html += '<td>'+product.userInfo.first_name+' '+product.userInfo.last_name+'</td>';
                                html += '<td ><button type="button" class="btn btn-info" onclick="editProduct('+product.id+')">Edit</button></td>';
                                html += '<td><button type="button" class="btn btn-danger" onclick="deleteProduct('+product.id+')" >Delete</button></td>';
                                html += '</tr>';
                                $('#productTable').DataTable().destroy();
                                $("#products").append(html);
                                $('#productTable').DataTable().draw();
                            $("#addForm").trigger('reset');
                            $("#productModal").modal('hide');
                        }
                    }
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        }
    });
    $(".form-control").click(function(){
        $(this).removeClass('error-field');;
        $("#errorAdd").hide();
    })
    function editProduct(id){
        $.ajax({
            url: "{{ url('api/get-product') }}/"+id,
            headers: {'Authorization': 'Bearer '+token},
            success: function(response) {
                console.log(response);
                if (response.status == 'Success') {
                    let product = response.data;
                    $("#productId").val(product.id);
                    $("#proName").val(product.name);
                    $("#proPrice").val(product.price);
                    $("#description").val(product.description);
                    $("#productModal").modal('show');
                }
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    }
    function deleteProduct(id){
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('api/delete-product') }}/"+id,
                    headers: {'Authorization': 'Bearer '+token},
                    success: function(response) {
                        console.log(response);
                        if (response.status == 'Success') {
                            location.reload();
                        }
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            }
        })
    }
</script>
@endsection