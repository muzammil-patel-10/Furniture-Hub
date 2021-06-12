<?php 
    require('top_inc.php');

    $order_id=get_safe_value($con,$_GET['id']);
    if(isset($_POST['update_order_status'])){
      $update_order_status=$_POST['update_order_status'];
      
     mysqli_query($con,"update `order` set order_status='$update_order_status' where id='$order_id'");

    }
 
?>    
<div class="content pb-0">
            <div class="orders">
               <div class="row">
                  <div class="col-xl-12">
                     <div class="card">
                        <div class="card-body">
                           <h1 class="king">ORDER DETAILS </h1>
                        </div>
                        <div class="card-body--">
                           <div class="table-stats order-table ov-h">
                           <table class="table">
                              <thead>
                                            <tr>
                                                <th class="product-thumbnail">Product Name</th>
												<th class="product-thumbnail">Product Image</th>
                                                <th class="product-name">Qty</th>
                                                <th class="product-price">Price</th>
                                                <th class="product-price">Total Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php
											
											$res=mysqli_query($con,"SELECT `order_detail`.*,product.name,product.img,`order`.`address`,`order`.city,`order`.`pincode` FROM `order_detail`,product,`order` WHERE order_id='$order_id' and product.id=`order_detail`.`product_id`and `order`.id='$order_id' ");
											
                                 $total_price=0;
											while($row=mysqli_fetch_assoc($res)){
                                    $address=$row['address'];
                                    $city=$row['city'];
                                    $pincode=$row['pincode'];
											$total_price=$total_price+($row['qty']*$row['price']);
                                 $order_status=$row['order_status'];
                                 
											?>
                                            <tr>
												<td class="product-name"><?php echo $row['name']?></td>
                                                <td class="product-name"> <img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$row['img']?>"></td>
												<td class="product-name"><?php echo $row['qty']?></td>
												<td class="product-name"><?php echo $row['price']?></td>
												<td class="product-name"><?php echo $row['qty']*$row['price']?></td>
                                                
                                            </tr>
                                            <?php } ?>
											<tr>
												<td colspan="3"></td>
												<td class="product-name">Total Price</td>
												<td class="product-name"><?php echo $total_price?></td>
                                                
                                            </tr>
                                        </tbody>
                                     </table>
                                     <div id="address_details">
                                     <strong>DELIVERY ADDRESS -</strong>
                                       <?php echo $address ?> ,<?php echo $city ?> ,<?php echo $pincode ?><br><br>
                                       <strong>ORDER STATUS -</strong>
                                       <?php
                                      $order_status_arr=mysqli_fetch_assoc(mysqli_query($con,"select order_status.name from order_status,`order` where `order`.id='$order_id' and `order`.order_status=order_status.id"));
                                      
                                       echo $order_status_arr['name'];
                                       ?><br><br>
                                                       <strong>CHANGE ORDER STATUS-</strong><br><br>
                                       <div>
                                       <form method="post">
									<select class="form-control" name="update_order_status" required>
										<option value="">Select Status</option>
										<?php
										$res=mysqli_query($con,"select * from order_status");
										while($row=mysqli_fetch_assoc($res)){
											if($row['id']==$categories_id){
												echo "<option selected value=".$row['id'].">".$row['name']."</option>";
											}else{
												echo "<option value=".$row['id'].">".$row['name']."</option>";
											}
										}
										?>
									</select><br>
									<input type="submit" class="btn btn-lg btn-info btn-block"/></form>
                                       </div>
                                     </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            </div>
            <?php 
    require('footer_inc.php');
?>