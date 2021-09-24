<html>

<head>
    <meta charset="utf-8">
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: normal;
        }
    </style>
</head>

<body>
    <p>Hello {{ $details['name'] }},</p>

    <p>The payment of {{ $details['total_transaction'] }} IDR is awaiting confirmation from our team. The transfer amount of {{ $details['receive'] }} {{ $details['currency_code'] }} will be sent to {{ $details['name_receive'] }} once payment is confirmed.</p>

    <hr style="width:430px; float: left;">
	<br>

    <p>
        <b>Track your transfer</b>
    </p>

    <p>
        <a href="{{ $details['name'] }}/transaction-invoice/{{ $details['id_transaction'] }}">
            <img src="transaction-processing.png">
        </a>
    </p>

    <p>
        You can track your transfer here <a href="{{ $details['name'] }}/transaction-invoice/{{ $details['id_transaction'] }}">here</a>.
    </p>

	<p>
		An estimation of the transfer period can be found <a href="{{ $details['name'] }}/transaction-invoice/{{ $details['id_transaction'] }}">here</a>.
	</p>

    <br>
    <p><img src="logo_adaremit.png"></p>



    <table style="width: 430px; font-size: 9pt; font-family: Arial,sans-serif; line-height:normal;" cellpadding="0"
		cellspacing="0">
		<tbody>
			<tr>
				<td style="font-size:10pt; font-family: Arial,sans-serif; color:#3c3c3b; font-weight: bold; padding-bottom:5px;">
					<span style="font-family: Arial, sans-serif; color:#3c3c3b;">Adaremit Support</span>
				</td>
			</tr>
			<tr>
				<td style="width:300px; vertical-align:top;" valign="top">
					<table cellpadding="0" cellspacing="0">
						<tbody>
							<tr>
								<td
									style="font-size:9pt; font-family: Arial,sans-serif; color:#3c3c3b; padding-bottom:5px;">
									<span style="font-family: Arial, sans-serif; color:#3c3c3b;">IT Support</span>
								</td>
							</tr>
							<tr>
								<td
									style="font-size:9pt; font-family: Arial,sans-serif; color:#3c3c3b; padding-bottom:5px;">
									<span style="font-family: Arial, sans-serif; color:#3c3c3b;">PT Anugrah Danamas
										Remit</span>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
				<td style="width:200px; vertical-align:top;" valign="top">
					<table cellpadding="0" cellspacing="0">
						<tbody>
							<tr>
								<td
									style="font-size:9pt; font-family: Arial, sans-serif; color:#3c3c3b; padding-bottom:1px;">
									<span style="font-family: Arial, sans-serif; color:#3c3c3b;"><span
											style="font-weight:bold;">M: </span>0811 6277 782</span>
								</td>
							</tr>
							<tr>
								<td
									style="font-size:9pt; font-family: Arial, sans-serif; color:#3c3c3b; padding-bottom:1px;">
									<span style="font-family: Arial, sans-serif; color:#3c3c3b;"><span
											style="font-weight:bold;">T: </span>(061) 7333 676</span>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
				<td style="width:200px; vertical-align:top;" valign="top">
					<table cellpadding="0" cellspacing="0">
						<tbody>
							<tr>
								<td
									style="font-size:9pt; font-family: Arial, sans-serif; color:#3c3c3b; padding-bottom:1px;">
									<span style="font-family: Arial, sans-serif; color:#3c3c3b;">&nbsp;
								</td>
							</tr>
							<tr>
								<td
									style="font-size:9pt; font-family: Arial, sans-serif; color:#3c3c3b; padding-bottom:1px;">
									<span style="font-family: Arial, sans-serif; color:#3c3c3b;"><span
											style="font-weight:bold;">W: </span>adaremit.co.id</span>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>

			<tr align="center">
				<td colspan="3" style="font-size:9pt; font-family: Arial,sans-serif; color:#3c3c3b; padding-bottom:5px;"
					width="430">
					<hr>
					<span style="font-family: Arial, sans-serif; color:#3c3c3b;">
						Adaremit (PT Anugrah Danamas Remit) is regulated as a remittance business by Bank
						Indonesia
						with License No. 12/68/MDN/7. You can verify this information at Bank Indonesia website here
						<br>
						Copyright © PT Adaremit 2020 - All rights reserved
					</span>
				</td>
			</tr>
			<tr>
				<td style="width:430px; padding-top:16px;" colspan="3" width="430">

					<img src="email-banner.png" style="width:430px;">
				</td>
			</tr>

		</tbody>
	</table>

</body>

</html>
