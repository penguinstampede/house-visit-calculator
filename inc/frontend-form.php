<hr>
<form>
  <input type="hidden" id="hv_baseprice" value="<?= $options['hv_baseprice'] ?>">
  <input type="hidden" id="hv_startingaddress" value="<?= $options['hv_address'] ?>">
  <input type="hidden" id="hv_freeradius" value="<?= $options['hv_radius'] ?>">
  <input type="hidden" id="hv_mileageprice" value="<?= $options['hv_mileageprice'] ?>">

  <p>The base price for house visits is $<?= $options['hv_baseprice'] ?>.</p>
  <p>Enter your address to receive an estimate for a visit to your house or business!</p>
  <textarea id="hv_client_address" name="hv_client_address" style="margin: 15px 0;"></textarea>
  <button id="hv_calculate" style="margin: 15px 0;">Calculate</button>

  <div id="hv_response"></div>
</form>
