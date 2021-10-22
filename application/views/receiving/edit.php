

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      List of
      <small>Received Products</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Received Products</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div id="messages"></div>

        <?php if($this->session->flashdata('success')): ?>
          <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('success'); ?>
          </div>
        <?php elseif($this->session->flashdata('error')): ?>
          <div class="alert alert-error alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('error'); ?>
          </div>
        <?php endif; ?>


        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Supply Details</h3>
          </div>
          <!-- /.box-header -->
          <form role="form" action="<?php base_url('receiving/create') ?>" method="post" class="form-horizontal">
              <div class="box-body">

                <?php echo validation_errors(); ?>


                <div class="col-md-4 col-xs-12 pull pull-left">

                <div class="form-group">
                    <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Invoice No</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" id="invoice_no" name="invoice_no" placeholder="Invoice No" autocomplete="off" readonly value="<?php echo $receiving_data['receiving']['invoice_no'] ?>">
                    </div>
                  </div>
                </div>

                </div>
                
                
                <br /> <br/>
                <table class="table table-bordered" id="product_info_table">
                  <thead>
                    <tr>
                      <th style="width:50%">Product</th>
                      <th style="width:10%">Qty</th>
                      <th style="width:20%">Amount</th>
                    </tr>
                  </thead>

                   <tbody>

                    <?php if(isset($receiving_data['receiving_item'])): ?>
                  
                      <?php $x = 1; ?>
                      <?php foreach ($receiving_data['receiving_item'] as $key => $val): ?>

                      <?php //var_dump($val);?>
                      
                       <tr id="row_<?php echo $x; ?>">
                         <td>
                          <select disabled class="form-control select_group product" data-row-id="row_<?php echo $x; ?>" id="product_<?php echo $x; ?>" name="product[]" style="width:100%;" onchange="getProductData(<?php echo $x; ?>)" required>
                             
                              <?php foreach ($products as $k => $v): ?>
                                <option value="<?php echo $v['p_id'] ?>" <?php if($val['product_id'] == $v['p_id']) { echo "selected='selected'"; } ?>><?php echo $v['name']; ?></option>
                              <?php endforeach ?>
                            </select>
                          </td>
                          <td>
                          <?php //var_dump($v);?>
                          <input type="text" readonly name="qty[]" id="qty_<?php echo $x; ?>" class="form-control"  value="<?php echo $val['supplies_qty'] ?>" autocomplete="off"></td>
                       
                          <td>
                            <input type="text" readonly name="amount[]" id="amount_<?php echo $x; ?>" class="form-control" value="<?php echo $val['amount'] ?>" autocomplete="off">
                          </td>
                       </tr>
                       <?php $x++; ?>
                     <?php endforeach; ?>
                   <?php endif; ?>
                   </tbody>
                </table>

                <br /> <br/>

              </div>
              <!-- /.box-body -->

              <div class="box-footer">

                <a target="__blank" href="<?php echo base_url() . 'receiving/printDiv/'.$receiving_data['receiving']['receiving_id'] ?>" class="btn btn-default" >Print</a>
                <a href="<?php echo base_url('receiving/') ?>" class="btn btn-warning">Back</a>
              </div>
            </form>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- col-md-12 -->
    </div>
    <!-- /.row -->
    

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script type="text/javascript">
  var base_url = "<?php echo base_url(); ?>";

  function printOrder(id)
  {
    if(id) {
      $.ajax({
        url: base_url + 'receiving/printDiv/' + id,
        type: 'post',
        success:function(response) {
          var mywindow = window.open('', 'new div', 'height=400,width=600');
          mywindow.document.write('<html><head><title></title>');
          mywindow.document.write('<link rel="stylesheet" href="<?php echo base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css') ?>" type="text/css" />');
          mywindow.document.write('</head><body >');
          mywindow.document.write(response);
          mywindow.document.write('</body></html>');

          mywindow.print();
          mywindow.close();

          return true;
        }
      });
    }
  }

  $(document).ready(function() {
    $(".select_group").select2();
    // $("#description").wysihtml5();

    $("#supplierNav").addClass('active');
  $("#viewSupplies").addClass('active');
    
    
    // Add new row in the table 
    $("#add_row").unbind('click').bind('click', function() {
      var table = $("#product_info_table");
      var count_table_tbody_tr = $("#product_info_table tbody tr").length;
      var row_id = count_table_tbody_tr + 1;

      $.ajax({
          url: base_url + '/receiving/getTableProductRow/',
          type: 'post',
          dataType: 'json',
          success:function(response) {
            

              // console.log(reponse.x);
               var html = '<tr id="row_'+row_id+'">'+
                   '<td>'+ 
                    '<select class="form-control select_group product" data-row-id="'+row_id+'" id="product_'+row_id+'" name="product[]" style="width:100%;" onchange="getProductData('+row_id+')">'+
                        '<option value=""></option>';
                        $.each(response, function(index, value) {
                          html += '<option value="'+value.id+'">'+value.name+'</option>';             
                        });
                        
                      html += '</select>'+
                    '</td>'+ 
                    '<td><input type="number" name="qty[]" id="qty_'+row_id+'" class="form-control" ></td>'+
                    '<td><input type="text" name="amount[]" id="amount_'+row_id+'" class="form-control" >'+
                    '<td><button type="button" class="btn btn-default" onclick="removeRow(\''+row_id+'\')"><i class="fa fa-close"></i></button></td>'+
                    '</tr>';

                if(count_table_tbody_tr >= 1) {
                $("#product_info_table tbody tr:last").after(html);  
              }
              else {
                $("#product_info_table tbody").html(html);
              }

              $(".product").select2();

          }
        });

      return false;
    });

  }); // /document



  // get the product information from the server
  function getProductData(row_id)
  {
    var product_id = $("#product_"+row_id).val();    
    if(product_id == "") {
      $("#rate_"+row_id).val("");
      $("#rate_value_"+row_id).val("");

      $("#qty_"+row_id).val("");           

      $("#amount_"+row_id).val("");
      $("#amount_value_"+row_id).val("");

    } else {
      $.ajax({
        url: base_url + 'receiving/getProductValueById',
        type: 'post',
        data: {product_id : product_id},
        dataType: 'json',
        success:function(response) {
          // setting the rate value into the rate input field
          
        //   $("#rate_"+row_id).val(response.price);
        //   $("#rate_value_"+row_id).val(response.price);

        //   $("#qty_"+row_id).val(1);
        //   $("#qty_value_"+row_id).val(1);

        //   var total = Number(response.price) * 1;
        //   total = total.toFixed(2);
        //   $("#amount_"+row_id).val(total);
        //   $("#amount_value_"+row_id).val(total);
          
        //   subAmount();
        } // /success
      }); // /ajax function to fetch the product data 
    }
  }


  function removeRow(tr_id)
  {
    $("#product_info_table tbody tr#row_"+tr_id).remove();
    //subAmount();
  }
</script>