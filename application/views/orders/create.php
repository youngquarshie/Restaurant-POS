<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="background-color:white !important">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>Orders</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Orders</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">

 

<div class="sellables-container">
  <div class="sellables">
    <div class="categories">
    <?php foreach ($categories as $k => $v): ?>
      
      <a class="category active cat" id="<?php echo $v['id'];?>" href="#"><?php echo $v['category_name']; ?></a>
      <?php endforeach ?>
      
    </div>
      <br>
    <div class="search">
    <input type="hidden" id="category_id">
    <input type="text" id="search_item" placeholder="Search..." class="form_control"/>
    </div>
    <br>

    <h4>All Items</h4>
    <div class="item-group-wrapper">

      
    
      <div class="item-group">
        
      </div>
     
    </div>
  </div>

  <div class="register-wrapper">

      <form role="form" action="<?php base_url('orders/create');?>" method="post" class="form-horizontal">

    <div class="customer">
    

      <div class="form-group">
        <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Order Type</label>
        <select class="form-control select_group product" id="order_type" name="order_type"  required>
                <!-- <option selected disabled>...Select Type of Order...</option> -->
                <option value="Take Away">Take Away</option>
                  <option value="Take In">Take In</option>
                  <option value="Delivery">Delivery</option>

              </select>
      </div>



    <div class="form-group">
    <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Table</label>
      <select class="form-control select_group product"  id="tables" name="order_table"   required>
      <option value="*****" selected>Not Applicable</option>
              <?php foreach ($tables as $k => $v): ?>
                <option value="<?php echo $v['table_name']; ?>"><?php echo $v['table_name']; ?></option>
              <?php endforeach ?>
            </select>

    </div>

    </div><br>



    <div class="register">
      <div class="products">
     
        

        <div class="product-bar">
        <table class="table" id="product_info_table">
                    <thead>
                      <tr>
                        <th>Item</th>
                        <th>Qty</th>
                        <th>Price</th>
                      </tr>
                    </thead>

                    <tbody>
                    

                    </tbody>
                  </table>
     
        </div>

        <div class="product-bar selected">
          <span>Total</span>
          <span id="total_amount">0.00</span>
          <input type="hidden" class="form-control" id="net_amount" name="net_amount" disabled
                      autocomplete="off">
            <input type="hidden" class="form-control" id="net_amount_value" name="net_amount_value"
            autocomplete="off">
        </div>

        
      </div>
      <br>

      <div class="pay-button">
        <button type="submit" class="btn btn-success btn-block">Pay</button>
      </div>


    </div>
    </form>
  </div>
</div>

<style>
/* @import url(https://fonts.googleapis.com/css?family=Open+Sans); */
 html {
	 height: 100%;
}


 body {
	 height: 100%;
	 background: #f5f7fa;
	 font-family: 'Open Sans', Helvetica, sans-serif;
}
 a, a:hover {
	 text-decoration: none;
}
 input:focus {
	 outline: none;
}
 body {
	 display: flex;
	 flex-direction: column;
	 height: 100%;
}
 /* body nav {
	 display: flex;
	 justify-content: space-between;
	 background: #34495e;
	 padding: 9px 0;
} */
 body nav ul {
	 display: flex;
	 align-items: center;
	 margin: 0;
}
 body nav ul li {
	 list-style-type: none;
}
 body nav ul li a {
	 color: #fff;
	 padding: 20px;
}
 body nav ul li a:hover {
	 background: #22303d;
}
 body nav .search input {
	 width: 394px;
	 height: 40px;
	 margin-right: 30px;
	 border: none;
	 border-radius: 5px;
	 font-size: 16px;
	 text-align: center;
}

.search input{
  width: 394px;
	 height: 40px;
	 margin-right: 30px;
	 border: 1px solid ash;
	 border-radius: 5px;
	 font-size: 16px;
	 text-align: center;
}

.search input::placeholder{
  font-style: italic;
}

 body nav .search input::placeholder {
	 font-style: italic;
}
 body .sellables-container {
	 display: flex;
	 flex: 1;
}
 body .sellables-container .sellables {
	 display: flex;
	 flex-direction: column;
	 flex: 1;
}
 body .sellables-container .sellables .categories {
	 display: flex;
	 align-items: center;
	 flex-wrap: wrap;
	 margin: 0.5em;
}
 body .sellables-container .sellables .categories .category {
	 padding: 17.5px;
	 margin: 2px;
	 border: 1px solid #c8cfd8;
	 border-radius: 5px;
	 background: #e6e9ed;
	 color: #424a54;
}
 body .sellables-container .sellables .categories .category:hover {
	 background: #c8cfd8;
}
 body .sellables-container .sellables .categories .active {
	 background: green;
	 color: white;
}
 body .sellables-container .sellables .categories .active:hover {
	 background: #abb5c2;
}
 body .sellables-container .sellables .item-group-wrapper {
	 overflow-y: scroll;
}
 body .sellables-container .sellables .item-group-wrapper .item-group {
	 display: flex;
	 flex-wrap: wrap;
}
 body .sellables-container .sellables .item-group-wrapper .item-group .item {
	 padding: 20px 30px;
	 margin: 0.5em 0.5em;
	 border-radius: 5px;
	 background: #9b59b6;
	 color: #fff;
}

body .sellables-container .sellables .categories .active {
  
    font-size: 20px;
}

.item-group > a {
  font-size:20px;
}
 body .sellables-container .sellables .item-group-wrapper .item-group .item:hover {
	 background: #804399;
}
 body .sellables-container .register-wrapper {
	 display: flex;
	 flex-direction: column;
	 align-items: center;
}
 body .sellables-container .register-wrapper .customer input {
	 height: 40px;
	 width: 394px;
	 margin-top: 16px;
	 border: 1px solid #ccc;
	 border-radius: 5px;
	 text-align: center;
	 font-size: 16px;
}
 body .sellables-container .register-wrapper .customer input::placeholder {
	 font-style: italic;
}
 body .sellables-container .register-wrapper .register {
	 display: flex;
	 flex-direction: column;
	 justify-content: space-between;
	 flex: 1;
	 width: 400px;
	 margin: 1em 2em;
	 box-shadow: 0px 1px 7px 0px rgba(0, 0, 0, 0.25);
	 border-radius: 5px;
	 background: #fff;
}
 body .sellables-container .register-wrapper .register .products {
	 display: flex;
	 flex-direction: column;
}
 body .sellables-container .register-wrapper .register .products .product-bar {
	 display: flex;
	 justify-content: space-between;
	 padding: 1em;
	 background: #fff;
}
 body .sellables-container .register-wrapper .register .products .product-bar:first-child {
	 margin-top: 1em;
}
 body .sellables-container .register-wrapper .register .products .product-bar:hover {
	 background: #e6e6e6;
}
 body .sellables-container .register-wrapper .register .products .selected {
	 background: #68b3c8;
	 color: #fff;
}
 body .sellables-container .register-wrapper .register .products .selected:hover {
	 background: #44a0b9;
}
 body .sellables-container .register-wrapper .register .pay-button {
	 display: flex;
	 align-items: center;
	 justify-content: center;
}
 body .sellables-container .register-wrapper .register .pay-button a {
	 padding: 10px 125px;
	 margin: 1em 0;
	 border-radius: 5px;
	 background: #42a07f;
	 color: #fff;
}
 body .sellables-container .register-wrapper .register .pay-button a:hover {
	 background: #3b8e71;
}

.current{
  background:blue;
}
 
</style>
    


  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script type="text/javascript">


  var base_url = "<?php echo base_url(); ?>";

  $.ajax({
      url: base_url + '/orders/getAllProducts/',
      method: "get",
   
      success: function (result) {

      
        $('.item-group').html(result);

        $('.add-cart').click(function (e) {
          e.preventDefault();
          var table = $("#product_info_table");

          var count_table_tbody_tr = $("#product_info_table tbody tr").length;

          var row_id = count_table_tbody_tr + 1;
          // alert(JSON.stringify(row_id));
          var product_id = $(this).attr("id");
          //lert(item_id);
          $.ajax({
            url: base_url + '/orders/getProductById/',
            method: "post",
            dataType:"json",
            data: {
              row_id: row_id,
              product_id: product_id
            },
            success: function (response) {
              var html = '<tr id="row_'+row_id+'">'+
                   '<td>'+response.name+'<input type="hidden" name="product[]" id="product_'+row_id+'" class="form-control" value="'+response.p_id+'"></td>'+
                    '<td><input type="number" min="1" name="qty[]" id="qty_'+row_id+'" class="form-control" value="1" onkeyup="getTotal('+row_id+')" onchange="getTotal('+row_id+')"></td>'+
                    '<td><input type="text" readonly name="amount[]" id="amount_'+row_id+'" value="'+response.price+'" class="form-control"><input type="hidden" readonly name="amount_value[]" id="amount_value_'+row_id+'" value='+response.price+' class="form-control"></td>'+
                    '<td><button type="button" class="btn btn-default" onclick="removeRow(\''+row_id+'\')"><i class="fa fa-close"></i></button></td>'+
                    '</tr>';

              if (count_table_tbody_tr >= 1) {
                $("#product_info_table tbody tr:last").after(html);
              } else {
                $("#product_info_table tbody").html(html);
              }

              $(".product").select2();
              //$("input[type='number']").inputSpinner();
              //alert();
              subAmount();



            }
          });
        });

        
      }
  });
  


  $("#search_item").keyup(function(){
  
    var table = $("#product_info_table");

          var count_table_tbody_tr = $("#product_info_table tbody tr").length;

          var row_id = count_table_tbody_tr + 1;

    var value = $(this).val();
    // var category_id = $("#category_id").val();

    $.ajax({
      url: base_url + '/orders/getCategoryProductBySearch/',
      method: "post",
      data: {
        // category_id: category_id,
        value:value

      },
      success: function (result) {

      
        $('.item-group').html(result);

        $('.add-cart').click(function (e) {
          e.preventDefault();
          var table = $("#product_info_table");

          var count_table_tbody_tr = $("#product_info_table tbody tr").length;

          var row_id = count_table_tbody_tr + 1;
          // alert(JSON.stringify(row_id));
          var product_id = $(this).attr("id");
          //lert(item_id);
          $.ajax({
            url: base_url + '/orders/getProductById/',
            method: "post",
            dataType:"json",
            data: {
              row_id: row_id,
              product_id: product_id
            },
            success: function (response) {
              var html = '<tr id="row_'+row_id+'">'+
                   '<td>'+response.name+'<input type="hidden" name="product[]" id="product_'+row_id+'" class="form-control" value="'+response.p_id+'"></td>'+
                    '<td><input type="number" min="1" name="qty[]" id="qty_'+row_id+'" class="form-control" value="1" onkeyup="getTotal('+row_id+')" onchange="getTotal('+row_id+')"></td>'+
                    '<td><input type="text" readonly name="amount[]" id="amount_'+row_id+'" value="'+response.price+'" class="form-control"><input type="hidden" readonly name="amount_value[]" id="amount_value_'+row_id+'" value='+response.price+' class="form-control"></td>'+
                    '<td><button type="button" class="btn btn-default" onclick="removeRow(\''+row_id+'\')"><i class="fa fa-close"></i></button></td>'+
                    '</tr>';

              if (count_table_tbody_tr >= 1) {
                $("#product_info_table tbody tr:last").after(html);
              } else {
                $("#product_info_table tbody").html(html);
              }

              $(".product").select2();
              $("input[type='number']").inputSpinner();
              //alert();
              subAmount();



            }
          });
        });

        
      }
  })
  });



  // $(document).on('submit', '#add_order', function(event){
	// 	event.preventDefault();
	// 	alert();
	// 	$.ajax({
	// 		url:base_url + '/orders/add_order',
	// 		method:'POST',
	// 		data:new FormData(this),
	// 		contentType:false,
	// 		processData:false,
	// 		success:function(data)
	// 		{
	// 			alert(data);
	// 			if(data.match('success'))
	// 			{
	// 				location.reload();
	// 			}
	// 		}
	// 	});
	// });

  $('.cat').click(function (e) {
    e.preventDefault();

    $('.cat.active').removeClass('active');
    $(this).addClass('active');
 

    var table = $("#product_info_table");

          var count_table_tbody_tr = $("#product_info_table tbody tr").length;

          var row_id = count_table_tbody_tr + 1;

    var category_id = $(this).attr("id");

    $("#category_id").html('');
    //alert(event_id);
    $.ajax({
      url: base_url + '/orders/getCategoryProduct/',
      method: "post",
      data: {
        category_id: category_id
      },
      success: function (result) {

        $('.item-group').html(result);
        // $("#search_item").show();
        $("#category_id").val(category_id);

        $('.add-cart').click(function (e) {
          e.preventDefault();
          var table = $("#product_info_table");

          var count_table_tbody_tr = $("#product_info_table tbody tr").length;

          var row_id = count_table_tbody_tr + 1;
          // alert(JSON.stringify(row_id));
          var product_id = $(this).attr("id");
          //lert(item_id);
          $.ajax({
            url: base_url + '/orders/getProductById/',
            method: "post",
            dataType:"json",
            data: {
              row_id: row_id,
              product_id: product_id
            },
            success: function (response) {
              var html = '<tr id="row_'+row_id+'">'+
                   '<td>'+response.name+'<input type="hidden" name="product[]" id="product_'+row_id+'" class="form-control" value="'+response.p_id+'"></td>'+
                    '<td><input type="number" min="1" name="qty[]" id="qty_'+row_id+'" class="form-control" value="1" onkeyup="getTotal('+row_id+')" onchange="getTotal('+row_id+')"></td>'+
                    '<td><input type="text" readonly name="amount[]" id="amount_'+row_id+'" value="'+response.price+'" class="form-control"><input type="hidden" readonly name="amount_value[]" id="amount_value_'+row_id+'" value='+response.price+' class="form-control"></td>'+
                    '<td><button type="button" class="btn btn-default" onclick="removeRow(\''+row_id+'\')"><i class="fa fa-close"></i></button></td>'+
                    '</tr>';

              if (count_table_tbody_tr >= 1) {
                $("#product_info_table tbody tr:last").after(html);
              } else {
                $("#product_info_table tbody").html(html);
              }

              $(".product").select2();
              $("input[type='number']").inputSpinner();
              //alert();
              subAmount();



            }
          });
        });


      }
    });
  });



  $(document).ready(function () {

    $(".select_group").select2();
    // $("#description").wysihtml5();

    $("#mainOrdersNav").addClass('active');
    $("#addOrderNav").addClass('active');

    var btnCust = '<button type="button" class="btn btn-secondary" title="Add picture tags" ' +
      'onclick="alert(\'Call your custom code here.\')">' +
      '<i class="glyphicon glyphicon-tag"></i>' +
      '</button>';


  }); // /document

  function getTotal(row = null) {


    if (row) {
      // var total = Number($("#rate_value_"+row).val()) * Number($("#qty_"+row).val());
      // var value =  Number($("#amount_value_" + row).val());
      // alert(value);
      var total = Number($("#amount_value_" + row).val()) * Number($("#qty_" + row).val());
      
      total = total.toFixed(2);
      $("#amount_" + row).val(total);
      //$("#amount_value_"+row).val(total);
      //alert(total);
      subAmount();

    } else {
      alert('no row !! please refresh the page');
    }
  }



  // calculate the total amount of the order
  function subAmount() {

    // var vat_charge = <?php //echo ($company_data['vat_charge_value'] > 0) ? $company_data['vat_charge_value']:0; ?>;

    var tableProductLength = $("#product_info_table tbody tr").length;
    //alert(tableProductLength)

    var totalSubAmount = 0;
    for (x = 0; x < tableProductLength; x++) {
      var tr = $("#product_info_table tbody tr")[x];
      var count = $(tr).attr('id');
      count = count.substring(4);

      totalSubAmount = Number(totalSubAmount) + Number($("#amount_" + count).val());
    } // /for

    totalSubAmount = totalSubAmount.toFixed(2);
    

    // sub total
    // $("#gross_amount").val(totalSubAmount);
    // $("#gross_amount_value").val(totalSubAmount);

    // vat
    // var vat = (Number($("#gross_amount").val())/100) * vat_charge;
    // vat = vat.toFixed(2);
    // $("#vat_charge").val(vat);
    // $("#vat_charge_value").val(vat);



    // total amount
    var totalAmount = Number(totalSubAmount);
    totalAmount = totalAmount.toFixed(2);
    // $("#net_amount").val(totalAmount);
    // $("#totalAmountValue").val(totalAmount);

    //alert(totalAmount);

    var discount = $("#discount").val();
    if (discount) {
      var grandTotal = Number(totalAmount) - Number(discount);
      grandTotal = grandTotal.toFixed(2);
      $("#net_amount").val(grandTotal);
      $("#total_amount").html(grandTotal);
      $("#net_amount_value").val(grandTotal);
    } else {
      $("#net_amount").val(totalAmount);
      $("#net_amount_value").val(totalAmount);
     
      $("#total_amount").html(totalAmount);

    } // /else discount 

  } // /sub total amount

  function removeRow(tr_id) {
    $("#product_info_table tbody tr#row_" + tr_id).remove();
    subAmount();
  }
</script>


