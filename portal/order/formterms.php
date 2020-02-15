<div class="row">
			<div class="space1"></div>
		</div>
		
		<div class="row">
			<div class="section dection-100">
				<p><?= gettext("CONDITIONS:")?></p>
				<ol>
					<li>
						<?= gettext("THE PRESENT CONTRACT COVERS A PERIOD OF")?>
						<input type="text" class="tel-number-field initial-width" name="conditionsmonths" value="<?php echo $rowFC['conditions_nummonths'];?>"> 
						<?= gettext("MONTHS STARTING ON THE")?> 
						<input type="date" class="input-field initial-width mandatory" data-name="Contract Starting Date" name="conditionsstartcontractdate" value="<?php echo $rowFC['conditions_startcontractdate'];?>">.  
	        			<br><br>
						<?= gettext("THE FIRST DELIVERY OF THE GOODS DESCRIBED IN ANNEX 3 WILL BE DELIVERED ON THE")?>
						<input type="date" class="input-field initial-width mandatory" data-name="First Delivery Date" name="conditionsfirstdeliverydate" value="<?php echo $rowFC['conditions_firstdeliverydate'];?>"> 
						<?= gettext("THE SECOND DELIVERY WILL SUCCEED IN FOUR MONTHS, THE THIRD DELIVERY IN EIGHT MONTHS.")?>
					</li>
					<li>
						<?= gettext("TOTAL AMOUNT OF THE AGREEMENT IS")?> 
						<input type="text" class="tel-number-field initial-width disabled" tabIndex="-1" id="conditions-price1" value="<?php echo $rowFC['total'];?>" readonly>$.
					</li>
					<li>
						<?= gettext("THE TOTAL AMOUNT OF")?> 
							<input type="text" class="tel-number-field initial-width disabled" tabIndex="-1" id="conditions-price2" value="<?php echo $rowFC['total'];?>" readonly>$ 
							<?= gettext("PAYABLE UNDER THIS AGREEMENT, WILL BE ACQUITTED IN")?> 
							<input type="text" class="tel-number-field initial-width" name="conditionspaymentmonths" value="<?php echo $rowFC['conditions_numwithdrawals'];?>"> 
							<?= gettext("WITHDRAWS FOR THE AMOUNT OF")?> 
                           <input type="text" class="tel-number-field initial-width" name="conditionsmonthlypayment" value="<?php echo $rowFC['conditions_withdrawalamount'];?>">$ 
                           <?= gettext("EACH. THE FIRST WITHDRAW WILL BE TAKEN ON THE")?> 
                           <input type="date" class="tel-number-field initial-width" name="conditionsfirstpaymentdate" value="<?php echo $rowFC['conditions_firstwithdrawaldate'];?>">. 
					</li>
					<li>
						<?= gettext("THE PRE-AUTHORIZED FROM COMPLETED BY THE CONSUMER, IS AN INTEGRAL PART OF THIS AGREEMENT.")?> 
					</li>
					<li>
						<?= gettext("THE CONSUMER RECOGNIZES THAT THE MERCHANT MAY TAKE THE NECESSARY ACTIONS TO VERIFY THE ACCURACY OF THE INFORMATION ON THE SOLVENCY AND TO COMMUNICATE SUCH INFORMATION TO CREDIT INSTITUTIONS, ALL WITHIN THE LIMITS PERMITTED BY THE ACT.")?>
					</li>
					<li>
						<?= gettext("IF MORE THAN ONE CONSUMER SIGNS THE CONTRACT, THEY JOINTLY AND SEVERALLY FORCE IS TOWARDS THE MERCHANT UNDER THE CONTRACT AGREEMENT. MORE THE CONSUMERS RECOGNIZES THAT THE MERCHANT MUST BE PAID IN FULL FOR THE FULL AMOUNT INDICATE ON THIS CONTRACT, FOR THE FULL TWELVE MONTH PERIOD, EVEN IF THE GOODS DESCRIBED IN ANNEX THREE IS DELIVERED IN TWO DELIVERIES.")?>
					</li>
					<li>
						<?= gettext("IF THE BUYER REFUSES TO RECEIVE A DELIVERY, IT WILL BE AUTOMATICALLY IN DEFAULT AND THEREFORE SHOULD PAY THE MERCHANT PLUS THE TOTAL BALANCE OF HIS DUTY PAYABLE UNDER THIS AGREEMENT, A PENALTY EQUAL TO SURPLUS 20% OF ALL THE SELLING PRICE. IF THE CONTRACT IS EXTENDED BEYOND THE MATURITY DATE OF THE LAST PAYMENT, INTEREST COST OF 2% PER MONTH WILL BE CHARGED ON THE BALANCE UNTIL PAYMENT IS FULLY PAID.")?>
						<br>
						<?= gettext("COUNTERVAILING  CHARGES OF $48, 00 WILL BE PAYABLE FOR SPECIES NOT HONOURED BY THE FINANCIAL INSTITUTION OF THE CONSUMER.")?>
					</li>
				</ol>
				<br>
				<div class="row">
					<div class="space1"></div><div class="initials"></div>
				</div>
				<p><?= gettext("THE CONSUMER RECOGNIZED THAT:")?></p>
				<ol style="list-style-type: upper-alpha;">
					<li>
						<?= gettext("THE MERCHANT HAS FIRST SIGNED TWO COPIES OF THIS AGREEMENT AND THE ANNEXES DULY COMPLETED;")?>
					</li>
					<li>
						<?= gettext("THE MERCHANT THEN GAVE HIM A SIGNED COPY OF THIS AGREEMENT AND THE ANNEXES.   IMPORTANT NOTE:  BIING IMPOSSIBLE TO PRINT, THE ANNEXE THREE (3) DESCRPTION OF THE MERCHADISE ORDERED, THIS ANNEXES IS GIVEN TO THE CUNSUMER(S) ON THE FRIST DELIVERY.")?>
					</li>
					<li>
						<?= gettext("THE MERCHANT ALLOWED HIM TO READ THE TERMS AND PROVIDED ADEQUATE EXPLANATIONS ON THE SCOPE AND EXTENT OF THE TERMS OF THIS AGREEMENT;")?>
					</li>
					<li>
						<?= gettext("IT HAS SIGNED TWO COPIES OF THE CONTRACT, HAS RETAINED ONE AND GAVE THE OTHER TO THE FOOD CONSULTANT")?>
					</li>
					<li>
						<?= gettext("THE MERCHANT WILL SEND A COPY OF THE SHEET COMMAND.")?>
					</li>
				</ol>
			</div>
		</div>
		
		<div class="row">
			<div class="space1"></div><div class="initials"></div>
		</div>
		
		
		<div class="row">
			<div class="section dection-100">
			<p><?= gettext("THE CONSUMER RECOGNIZED THAT:")?></p>
			<b><i><?= gettext("Resolution of the consumer rights statement")?></i></b><br><br>

			<i><?= gettext("(Act on the protection of the consumer, S.58)")?></i><br><br>
			
			<?= gettext("You can resolve this contract for any reason, for a period of 10 days after receipt of the double of the contract and the documents that needs to be appended.")?>
			<br><br>
			<?= gettext("If you do not receive goods or service within 30 days of a date specified in the contract, you have 1 year to rescind the contract. However, you lose this right of resolution if you accept the delivery after this 30 day period. The time of exercise of the right of resolution may also be increased to 1 year for other reasons, including for lack permits, for absence or disability of bail, for lack of delivery or non-conformity of the contract. For more information, contact a legal adviser or the Office of consumer protection.")?>
			<br><br>
			<?= gettext("When the contract is resolved, the itinerant trader should you repay all monies you have paid and return you anything although it received payment, in Exchange or deposit; if it can render this property, the itinerant trader must give a sum corresponding to the price of this well indicated in the contract or, failing that, the value of this property within 15 days of the resolution. In the same period, you must submit to the itinerant trader the property that you received from the merchant. To resolve the contract sufficiently, either to the proprietor or his representative that you received the merchandise from, you will need to return the form below or send him another notice to this effect. The form or notice must be sent to the proprietor or his representative, the address indicated on the form or another proprietor or representative address indicated in the contract. The notice must be delivered in person or be given by any other means enabling the consumer to prove its shipment: by registered mail, by e-mail, by fax or by courier.")?>
						
			</div>
		</div>
		
		<div class="row">
			<div class="space1"></div>
		</div>
		

		
		