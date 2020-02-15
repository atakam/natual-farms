<script src="js/signature_pad.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	  <script>
	  if ( $('[type="date"]').prop('type') != 'date' ) {
	        $('[type="date"]').datepicker({ dateFormat: 'yy-mm-dd' }).val();
	    }
	  </script>
	  
  	<script src="js/app.js"></script>
  	<script type="text/javascript" charset="utf-8">
               $(document).ready(function(){
                 //$("a[rel^='prettyPhoto']").prettyPhoto();
               });
             </script>

	<script>

	var prodIndex = 1;
	var max_fields      = 100; //maximum input boxes allowed
    var wrap;
    var add_button      = $(".add_field"); //Add button ID
    
    var x = 0; //initlal text box count
    var x2 = 0;

	$(document).ready(function() {

		wrap = document.getElementById("cartItems"); //Fields wrapper
	    $(wrap).on("click",".remove_field", function(e){ //user click on remove text
	    	document.getElementById("qty1"+$(this).attr('name')).value = 0 ;
		    document.getElementById("qty2"+$(this).attr('name')).value = 0 ;
		    document.getElementById("qty3"+$(this).attr('name')).value = 0 ;
		    updateTotal();
	        e.preventDefault(); $(this).parent('div').parent('div').remove(); x2--;

	        var elems = document.getElementsByClassName('cart-category'), rmE=[];
			for (var i=0; i<elems.length; i++){
				var cat = elems[i].querySelectorAll('.product-line');
				if (cat.length === 0) {
					rmE.push(elems[i]);
				}
			}
			rmE.forEach(removeEl);
	    })
	    
	    // Adjust height of products
	    adjustHeights();

	    initPages();

	    if ( $('[type="date"]').prop('type') != 'date' ) {
	        $('[type="date"]').datepicker();
	    }
	});

	function language(l){
		 window.location.href = window.location.href.split("#")[0] + "&lang=" + l;
	}

    function checkQuatity(){
    	var err = 0;
        var elems = document.getElementsByClassName('remove-product'), ctp=0;
		for (var i=0; i<elems.length; i++){
			var q1 = parseInt(elems[i].parentNode.parentNode.querySelector('.delivered1').value);
			var q2 = parseInt(elems[i].parentNode.parentNode.querySelector('.delivered2').value);
			var q3 = parseInt(elems[i].parentNode.parentNode.querySelector('.delivered3').value);
	    	if ((q1+q2+q3) === 0){
	    		ctp++;
	    	}
		}
		if (ctp > 0) {
        	alert("<?= gettext('You must fill in at least 1 delivery quatity for')?>: " + ctp + " <?= gettext('Products')?>.\n\n" + 
        			"<?= gettext('Or click on VALIDATE CART to remove unwanted products')?>.");
			err = 1;
        }

        var elems = document.getElementById("mycart").querySelectorAll(".products-select");
        if (elems != null) {
        	var i, ct = 0;
            for (i=0; i<elems.length; i++)
            {
            	var qq = elems[i].value;

    	    	if (qq == "0"){
    	    		ct++;
    		    }
            }
        }

        if (ct > 0) {
        	alert("<?= gettext('You must choose a product size for')?>: " + ct + " <?= gettext('Products')?>.\n\n" + 
        			"<?= gettext('Or click on VALIDATE CART to remove unwanted products')?>.");
			err = 1;
        }
        
        if (err == 1) {
			window.location = "#mycart";
		}
		else {
			window.location = "#shopTop";
		}
    }

    function validateCart() {
		var elems = document.getElementsByClassName('remove-product');
		var remElems = [];

		for (var i=0; i<elems.length; i++){
			var pdtSelect = elems[i].parentNode.parentNode.querySelector('.products-select');
			var q1 = parseInt(elems[i].parentNode.parentNode.querySelector('.delivered1').value);
			var q2 = parseInt(elems[i].parentNode.parentNode.querySelector('.delivered2').value);
			var q3 = parseInt(elems[i].parentNode.parentNode.querySelector('.delivered3').value);
	    	if (pdtSelect.value == "0" || (q1+q2+q3) === 0){
	    		remElems.push(elems[i]);
	    	}
		}

		remElems.forEach(clickEl);
		
    }

    function clickEl(item, i) {
    	item.click();
    }

    function removeEl(item, i) {
    	item.parentNode.removeChild(item);
    }

    function clearAllProducts() {
		var elems = document.getElementsByClassName('remove-product');
		while (elems.length > 0){
			elems[0].click();
		}
    }

    function addAllProducts() {
		var tabs = document.getElementsByClassName('tab');
		for (var i=0; i<tabs.length; i++){
			var elems = tabs[i].querySelectorAll('.pname');
			for (var j=elems.length-1; j>=0; j--){
				elems[j].click();
			}
		}
    }

    function addProductById(id) {
		document.getElementById(id).click();
    }

	function addProduct(lThis, none){ //on add input button click

		if(x2 < max_fields){ //max input box allowed
            x++; //text box increment
            x2++;

            var wrap = document.getElementById("cartItems");

            var catDiv = document.getElementById('cart-'+lThis.getAttribute("data-catslug"));
            if (catDiv === null) {
				catDiv = document.createElement("div");
				catDiv.setAttribute("class", "cart-category");
				catDiv.setAttribute("id", 'cart-'+lThis.getAttribute("data-catslug"));

				var catTitle = document.createElement("h3");
				catTitle.appendChild(document.createTextNode(lThis.getAttribute("data-category").toUpperCase()));
				catDiv.appendChild(catTitle);
				
				var divElemClear = document.createElement("div");
	            divElemClear.setAttribute("class", "clear");
	            catDiv.appendChild(divElemClear);

	            catDiv.appendChild(document.createElement("div"));

	            divElemClear = document.createElement("div");
	            divElemClear.setAttribute("class", "clear");
	            
	            wrap.appendChild(catDiv);
	            wrap.appendChild(divElemClear);
            }
            
            var divElem1 = document.createElement("div");
            divElem1.setAttribute("class", "section section-33");

            var inputElem = document.createElement("div");
            inputElem.setAttribute("class", "extra-input products input-field");

            var inputElemTxt = document.createElement("span");
            inputElemTxt.setAttribute("id", "name" + (x-1));
            //inputElem.setAttribute("data-points", lThis.getAttribute("data-points"));

            var imgElem = document.createElement("img");
            imgElem.setAttribute("src", "../order/images/products/" + lThis.getAttribute("data-image"));
            
            inputElem.appendChild(imgElem);
            inputElemTxt.appendChild(document.createTextNode(lThis.getAttribute("data-name")));
            inputElem.appendChild(inputElemTxt);

	        var pdtid = document.createElement("input");
	        pdtid.setAttribute("class", "hidden");
	        pdtid.setAttribute("id", "productId" + lThis.getAttribute("data-id"));
	        pdtid.value = lThis.getAttribute("data-id");
	            
            var divElem2 = document.createElement("div");
            divElem2.setAttribute("class", "section section-25");

            var divElem12 = document.createElement("div");
            divElem12.setAttribute("class", "section section-25");

            var inputElem2 = document.createElement("select");
            inputElem2.setAttribute("name", "product" + (x-1));
            inputElem2.setAttribute("class", "extra-input input-field products-select");
            inputElem2.setAttribute("id", "detail" + (x-1));
            inputElem2.setAttribute("data-id", lThis.getAttribute("data-id"));
            inputElem2.setAttribute("oninput", "updateTotal()");
            divElem12.appendChild(inputElem2);

            var divElem2p = document.createElement("div");
            divElem2p.setAttribute("class", "section section-10");
            
            var codeTxt = document.createElement("span");
            codeTxt.setAttribute("class", "codetext");
            codeTxt.appendChild(document.createTextNode(lThis.getAttribute("data-code")));
            divElem2p.appendChild(codeTxt);
            
            var details = lThis.getAttribute("data-details").split("~");

            // option 0
            var optElem = document.createElement("option");
			optElem.setAttribute("value", "0");
			optElem.appendChild(document.createTextNode("<?= gettext('Please select size')?>"));

			inputElem2.appendChild(optElem);
			
            var i;
            for (i=0; i<details.length; i++)
            {
				var optElem = document.createElement("option");
				optElem.setAttribute("value", details[i].split(",")[0]);
				optElem.setAttribute("data-point", details[i].split(",")[1]);
				optElem.appendChild(document.createTextNode(details[i].split(",")[2]));

				inputElem2.appendChild(optElem);
            }

            var divElem3 = document.createElement("div");
            divElem3.setAttribute("class", "section section-25");
            divElem3.setAttribute("id", "productQtyId" + lThis.getAttribute("data-id"));
            
            var inputqty1 = document.createElement("input");
            inputqty1.setAttribute("name", "qty1" + (x-1));
            inputqty1.setAttribute("class", "tel-number-field mandatory quantity delivered1");
            inputqty1.setAttribute("id", "qty1" + (x-1));
            inputqty1.setAttribute("value", "0");
            inputqty1.setAttribute("type", "number");
            inputqty1.setAttribute("oninput", "updateTotal()");
            divElem3.appendChild(inputqty1);

            var divElem4 = document.createElement("div");
            divElem4.setAttribute("class", "section section-25");
            
            var inputqty2 = document.createElement("input");
            inputqty2.setAttribute("name", "qty2" + (x-1));
            inputqty2.setAttribute("class", "tel-number-field mandatory quantity delivered2");
            inputqty2.setAttribute("id", "qty2" + (x-1));
            inputqty2.setAttribute("value", "0");
            inputqty2.setAttribute("type", "number");
            inputqty2.setAttribute("oninput", "updateTotal()");
            divElem4.appendChild(inputqty2);
            
            var divElem5 = document.createElement("div");
            divElem5.setAttribute("class", "section section-25");
            
            var inputqty3 = document.createElement("input");
            inputqty3.setAttribute("name", "qty3" + (x-1));
            inputqty3.setAttribute("class", "tel-number-field mandatory quantity delivered3");
            inputqty3.setAttribute("id", "qty3" + (x-1));
            inputqty3.setAttribute("value", "0");
            inputqty3.setAttribute("type", "number");
            inputqty3.setAttribute("oninput", "updateTotal()");
            divElem5.appendChild(inputqty3);

            var divElempt = document.createElement("div");
            divElempt.setAttribute("class", "section section-20");
            
            var inputpt = document.createElement("input");
            inputpt.setAttribute("class", "tel-number-field disabled quantity");
            inputpt.setAttribute("id", "pt" + (x-1));
            inputpt.setAttribute("value", "0");
            inputpt.setAttribute("type", "number");
            inputpt.setAttribute("style", "border: 0px;font-size:14px; padding: 8px; color:red; padding-right: 0;");
            inputpt.setAttribute("readonly", "");
            divElempt.appendChild(inputpt);

            if (none == null){
	            var link = document.createElement("a");
	            link.setAttribute("href", "#");
	            link.setAttribute("name", (x-1));
	            link.setAttribute("class", "fa fa-trash remove_field remove remove-product");
            }

            var remElem = document.createElement("div");
            remElem.setAttribute("class", "section section-5");
            remElem.setAttribute("style", "margin: 0; width: 5%");
            if (none == null){
            	remElem.appendChild(link);
            }

            link = document.createElement("a");
            link.setAttribute("style", "cursor:pointer; font-size:21px; color: #809621; margin-left: 6px");
            link.setAttribute("onclick", "addProductById('"+lThis.id+"')");
            link.setAttribute("class", "fa fa-plus");
            remElem.appendChild(link);

            divElem1.appendChild(document.createElement("span"));
            divElem1.appendChild(inputElem);
            divElem2.appendChild(divElem3);
            divElem2.appendChild(divElem4);
            divElem2.appendChild(divElem5);
            divElem2.appendChild(divElempt);

            var divElemClear = document.createElement("div");
            divElemClear.setAttribute("class", "clear");

            var divElem = document.createElement("div");
            divElem.setAttribute("class", "product-line");
            divElem.appendChild(divElem1);
            divElem.appendChild(divElem2p);
            divElem.appendChild(divElem12);
            divElem.appendChild(divElem2);
            divElem.appendChild(remElem);
            divElem.appendChild(pdtid);
            divElem.appendChild(divElemClear);

            divElemClear = document.createElement("div");
            divElemClear.setAttribute("class", "clear");

            catDiv.insertBefore(divElemClear, catDiv.children[2]);
            catDiv.insertBefore(divElem, catDiv.children[2]);

            wrap.scrollTop = 0;
        }
		if (typeof disableDelivered === "function")
		{
			disableDelivered();
		}
        updateTotal();
        oneOnly();
    }

		function updateTotal() {
			var elems = document.getElementsByClassName("products-select"), totalPts = 0, totalPrice = 0, totalQty = 0;
            var tqt1=0, tqt2=0, tqt3=0;
			for (i = 0; i < elems.length; i++) {
				var pts = Number(elems[i].options[elems[i].selectedIndex].getAttribute("data-point"));
				var price = Number(elems[i].getAttribute("data-price"));

				var qtys = elems[i].parentNode.parentNode.querySelectorAll(".quantity");
				var perPdtPts = document.getElementById("perPdtPts" + elems[i].getAttribute("data-id"));
				if (qtys != null){
					var q1 = Number(qtys[0].value);
					var q2 = Number(qtys[1].value);
					var q3 = Number(qtys[2].value);
					
					tqt1 = tqt1 + (q1 * pts);
					tqt2 = tqt2 + (q2 * pts);
					tqt3 = tqt3 + (q3 * pts);

					tqty =  (q1 + q2 + q3);
					
					pts =  tqty * pts;

					qtys[3].value = pts;

					//perPdtPts.innerHTML = tqty === 0 ? "" : tqty;
		            if (tqty === 0) {
		            	perPdtPts.parentElement.classList.remove('product-item-selected');
				    }
		            else {
		            	perPdtPts.parentElement.classList.add('product-item-selected');
			        }
		            totalPts = totalPts + pts;
					totalQty = totalQty + tqty;
					//totalPrice = totalPrice + price;
				}
				else {
					pts = 0;
				}
				
// 				price =  (Number(document.getElementById("qty1" + i).value)
// 						+ Number(document.getElementById("qty2" + i).value)
// 						+ Number(document.getElementById("qty3" + i).value))
// 			            * price;
				
			}

			document.getElementById("points1").innerHTML = tqt1;
			document.getElementById("points2").innerHTML = tqt2;
			document.getElementById("points3").innerHTML = tqt3;
			
			document.getElementById("points").value = totalPts;

			if(document.getElementById("cartPoints")) {
				document.getElementById("cartPoints").innerHTML = totalPts;
			}

			if(document.getElementById("cartPoints1")) {
				document.getElementById("cartPoints1").innerHTML = totalPts;
				document.getElementById("cartPoints1").style.color = "green";
				document.getElementById("cartPoints1").parentNode.style.borderColor = "green";
				if (totalPts > Number(document.getElementById("oldPoints1").innerHTML))
				{
					document.getElementById("cartPoints1").style.color = "red";
					document.getElementById("cartPoints1").parentNode.style.borderColor = "red";
				}
			}

			if(document.getElementById("cartPoints2")) {
				document.getElementById("cartPoints2").innerHTML = totalPts;
				document.getElementById("cartPoints2").style.color = "green";
				document.getElementById("cartPoints2").parentNode.style.borderColor = "green";
				if (totalPts > Number(document.getElementById("oldPoints2").innerHTML))
				{
					document.getElementById("cartPoints2").style.color = "red";
					document.getElementById("cartPoints2").parentNode.style.borderColor = "red";
				}
			}

			if(document.getElementById("price")) {
				totalPrice = document.getElementById("price").value;
				//document.getElementById("price").value = totalPrice;
				
				var rebate = Number(document.getElementById("rebate").value);
				var deposit = Number(document.getElementById("deposit").value);
				
				document.getElementById("subtotal").value = totalPrice - rebate;
				document.getElementById("total").value = totalPrice - rebate - deposit;
				document.getElementById("conditions-price1").value = totalPrice - rebate - deposit;
				document.getElementById("conditions-price2").value = totalPrice - rebate - deposit;
			}
		}

        function showTab(id) {
			var elms = document.getElementsByClassName("tab");
			var i;
			for (i=0; i<elms.length; i++) {
				elms[i].classList.remove("active");
			}
			document.getElementById(id).className += " active";

			var tabsT = document.getElementsByClassName("tabTitle");
			for (i=0; i<tabsT.length; i++) {
				tabsT[i].classList.remove('active');
			}
			document.getElementById("tab-"+id).className += " active";

			initPages();
		}
		
		function adjustHeights() {
			var i;
			var pdts = document.getElementsByClassName("product-display");
			var maxHeight = 0;
		    for (i=0; i< pdts.length; i++){
			    if (maxHeight < pdts[i].clientHeight)
			    {
			    	maxHeight = pdts[i].clientHeight
				}
		    }
		    for (i=0; i< pdts.length; i++){
		    	pdts[i].style.height = maxHeight + 'px';
		    }
		}

		function initPages() {

			var lists = document.getElementsByClassName("product-list");
			var i, j;

			// Reset all product pages
			var resets = document.getElementsByClassName("reset");
			while (resets.length > 0) {
				resets[0].parentNode.removeChild(resets[0]);
			}

			// initialise product pages for selected category
			for (i=0; i<lists.length; i++) {

				if (lists[i].parentElement.classList.contains("active")) {
					var show_per_page = <?php echo $numOfColumns * $numOfRows ?>;
					var number_of_items = lists[i].children.length;
				    var number_of_pages = Math.ceil(number_of_items / show_per_page);
	
				    lists[i].parentElement.innerHTML = lists[i].parentElement.innerHTML + ("<div class='clear reset'></div><div class='controls reset demo'></div><div class='clear reset'></div><input id='current_page' type='hidden' class='reset'><input id='show_per_page' type='hidden'class='reset'>");
					$('#current_page').val(0);
				    $('#show_per_page').val(show_per_page);
	
				    var navigation_html = '<a class="prev" onclick="previous(' + lists[i].id + ')"><i class="fa fa-chevron-left"></i></a>';
				    var current_link = 0;
				    while (number_of_pages > current_link) {
				        navigation_html += '<a class="page" onclick="go_to_page(' + lists[i].id + ',' + current_link + ')" longdesc="' + current_link + '">' + (current_link + 1) + '</a>';
				        current_link++;
				    }
				    navigation_html += '<a class="next" onclick="next(' + lists[i].id + ')"><i class="fa fa-chevron-right"></i></a>';
	
				    $('.controls').html(navigation_html);
				    $('.controls .page:first').addClass('activePage');
	
				    var listsChildren = lists[i].children;
				    var limit = show_per_page;
				    for (j=0; j<listsChildren.length; j++) {
				    	listsChildren[j].style.display = "none";
				    }
				    if (show_per_page > listsChildren.length) {
						limit = listsChildren.length;
					}
				    for (j=0; j<limit; j++) {
				    	listsChildren[j].style.display = "block";
				    }
				}
			}

		}

		function go_to_page(ul, page_num) {
		    var show_per_page = parseInt($('#show_per_page').val(), 0);

		    var childrenList = ul.children;

		    start_from = page_num * show_per_page;

		    end_on = start_from + show_per_page;

            var j;
            var limit = end_on;
		    for (j=0; j<childrenList.length; j++) {
		    	childrenList[j].style.display = "none";
		    }
		    if (show_per_page > (childrenList.length - start_from)) {
				limit = childrenList.length;
			}
		    for (j=start_from; j<limit; j++) {
		    	childrenList[j].style.display = "block";
		    }

		    $('.page[longdesc=' + page_num + ']').addClass('activePage').siblings('.activePage').removeClass('activePage');

		    $('#current_page').val(page_num);
		}

		function previous(ul) {

		    new_page = parseInt($('#current_page').val(), 0) - 1;
		    //if there is an item before the current active link run the function
		    if ($('.activePage').prev('.page').length == true) {
		    	go_to_page(ul, new_page);
		    }
		}

		function next(ul) {
		    new_page = parseInt($('#current_page').val(), 0) + 1;
		    //if there is an item after the current active link run the function
		    if ($('.activePage').next('.page').length == true) {
		        go_to_page(ul, new_page);
		    }

		}	

	</script>
</div>