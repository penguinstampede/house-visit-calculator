<style>
  .row .column{
    width: 50%;
    float: left;
  }
  .row select{
    width: 25em;
  }
  #vist_map{
    max-width: 100%;
  }
</style>
<div class="wrap">
  <h1>Edit House Visit Settings</h1>
  <div class="row">
    <div class="column">
      <form method="post" action="options.php">
        <?php
          settings_fields('housevisit_settings_options');
          do_settings_sections('house-visits');
        ?>
        <?php submit_button('Save Changes'); ?>
      </form>
    </div>
    <div class="column">
      <img style="display: none;" id="vist_map" src="#" alt="Google Map">
    </div>
  </div>
</div>
