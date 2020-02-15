<div>
<div class="section section-100" style="font-size: 16px;padding-bottom: 20px;font-style: italic;">
	<?= gettext("Select item from the list below to add / modify your order!"); ?>
</div>
				<div class="section section-100 tabs">
				<?php 
					$sqlCat = "SELECT * FROM products_category";
					$resultsCat = mysqli_query($conn, $sqlCat) or die ($sqlCat."<br>".mysqli_error());
					$firstTab = 0;
					while ($rowCat = mysqli_fetch_array($resultsCat))
					{
						if ($firstTab === 0)
						{
							$firstTab = 1;
				?>
							<span id="tab-<?php echo $rowCat['slug']; ?>" class="tabTitle active" onclick="showTab('<?php echo $rowCat['slug']; ?>')"><?php echo ($language == "en_US")?$rowCat['name_en']:$rowCat['name_fr']; ?></span>
				<?php 
						}
						else {
				?>
							<span id="tab-<?php echo $rowCat['slug']; ?>" class="tabTitle" onclick="showTab('<?php echo $rowCat['slug']; ?>')"><?php echo ($language == "en_US")?$rowCat['name_en']:$rowCat['name_fr']; ?></span>
				<?php
						}
			    	}
			    ?>
			                <span class="cart-tab"><a href='#mycart'><i class="fa fa-shopping-cart"></i></a></span>
				</div>
				
				<?php 
				$resultsCat = mysqli_query($conn, $sqlCat) or die ($sqlCat."<br>".mysqli_error());
				$firstTab = 0;
				while ($rowCat = mysqli_fetch_array($resultsCat))
				{
				
				if ($firstTab === 0)
				{
					?>
					<div class="section section-100 tab active" id="<?php echo $rowCat['slug']; ?>">
					<?php 
				}
				else {
				?>
					<div class="section section-100 tab" id="<?php echo $rowCat['slug']; ?>">
					<?php 
				}
				$firstTab++;
				
					echo "<ul class='nodisplay active product-list' id='".$rowCat['slug']."list'>";
					
					$sql = "SELECT * FROM products WHERE category_id=".$rowCat['id'] . " AND active=1";
					
					$results = mysqli_query($conn, $sql) or die ($sql."<br>".mysqli_error());

					while ($row = mysqli_fetch_array($results))
					{
						$sql2 = "SELECT * FROM products_details WHERE product_id=".$row['id'].";";
						//echo $sql2;
						$results2 = mysqli_query($conn, $sql2) or die ($sql2."<br>".mysqli_error());
						$cart = array();
						
						$codes = " [ ";
						
						while ($row2 = mysqli_fetch_array($results2))
						{
							$details = array();
							array_push($details, $row2['id']);
							array_push($details, $row2['point']);
							
							$sql3 = "SELECT * FROM product_packaging WHERE id=".$row2['packaging_id']." LIMIT 1";
							$results3 = mysqli_query($conn, $sql3) or die ($sql3."<br>".mysqli_error());
							$row3 = mysqli_fetch_array($results3);
							array_push($details, "[". $row2['code'] ."] " . $row3['type'] . " : " . $row3['quantity']);
							
							array_push($cart, $details);
							
							$codes .= $row2['code'] . ', ';
						}
						
						$codes = rtrim($codes, ', ');
						$codes .= " ] ";
						
						$details = "";
						foreach($cart as $r) {
							foreach ($r as $t)
							{
								$details .= $t . ",";
							}
							$details = rtrim($details, ",");
							$details .= "~";
						}
						$details = rtrim($details, "~");
						
						$width = str_replace(",", ".", (100/$numOfColumns));
						$name = ($language == "en_US")?$row['name_en']:$row['name_fr'];
						$cat  = ($language == "en_US")?$rowCat['name_en']:$rowCat['name_fr'];
						$slug  = $rowCat['slug'];
						echo "<li class='section product-display' style='width:".$width."%;'>";
						echo "<span onclick='addProduct(this)' data-image='".$row['image_name']."' data-name='".$name."' data-catslug='".$slug."' data-category='".$cat."' data-details='".$details."' data-code='".$codes."' data-id='".$row['id']."'>";
						echo "<a href='#mycart'><img src='images/products/".$row['image_name']."' alt='productImage' /></a>";
						echo "</span>";
						echo "<div class='pname' onclick='addProduct(this)' id='edit".$row['id']."' data-image='".$row['image_name']."' data-name='".$name."' data-catslug='".$slug."' data-category='".$cat."' data-details='".$details."' data-code='".$codes."' data-id='".$row['id']."'>
							 <p>".$name.$codes."</p>".
    		                 "<a href='#mycart' class='product-item-select'><span class='perPdtPts' id='perPdtPts".$row['id']."'></span><span>".gettext("Add")."</span></a></div>";
						echo "</li>";
					}
					echo "</ul>";
					
					?>
				</div>
				<?php } ?>
			</div>
			
			<?php 
			$sqlOrd = "SELECT * FROM orders WHERE form_id=".$fid;
			if ($rowFC['edited_status']==1||isset($_GET['edited'])){
				$sqlOrd = "SELECT * FROM orders_updates WHERE form_id=".$fid;
				$resultsOrd = mysqli_query($conn, $sqlOrd);
				$count = 0;
				while ($rowOrd = mysqli_fetch_array($resultsOrd))
				{
					$count++;
				}
				if ($count === 0) {
					$sqlOrd = "SELECT * FROM orders WHERE form_id=".$fid;
				}
			}
			$resultsOrd = mysqli_query($conn, $sqlOrd) or die ($sqlOrd."<br>".mysqli_error());
			echo '<script type="text/javascript">';
			echo '$(document).ready(function() {';
			$countPtl = 0;
			while ($rowOrd = mysqli_fetch_array($resultsOrd))
			{
				$sqlPtl = "SELECT * FROM products_details WHERE id=".$rowOrd['product_details_id']." LIMIT 1";
				$resultsPtl = mysqli_query($conn, $sqlPtl) or die ($sqlPtl."<br>".mysqli_error());
				$rowPtl = mysqli_fetch_array($resultsPtl);
					
				echo 'document.getElementById("edit'.$rowPtl["product_id"].'").click();';
				echo 'document.getElementById("name'.$countPtl.'").innerHTML = document.getElementById("name'.$countPtl.'").innerHTML;';
				echo 'document.getElementById("detail'.$countPtl.'").value = '.$rowOrd["product_details_id"].';';
				echo 'document.getElementById("qty1'.$countPtl.'").value = '.$rowOrd["quantity1"].';';
				echo 'document.getElementById("qty2'.$countPtl.'").value = '.$rowOrd["quantity2"].';';
				echo 'document.getElementById("qty3'.$countPtl++.'").value = '.$rowOrd["quantity3"].';';
				echo 'updateTotal();';
			}
			echo '});';
			echo '</script>';
			?>
			
			<div class="clear"></div>