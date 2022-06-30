

	<link href="<?php  asset('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
  
  <div width="100%" style="margin:auto">
      <h2 style="text-align: center;">नगर परिषद, हिंगोली</h2>
      <h2 style="text-align: center">&#9830;पावती&#9830;</h2>
      <div class="row">
          <div class="col-sm-6">पुस्तक क्र. (#<?=$user['id']?>)</div>
          <div class="col-sm-6" style="text-align: right;">दिनांक: <?=Date('d/m/Y')?></div>
      </div>
      <div class="row">
          <div class="col-sm-12">
              घरमालकाचे नाव: <?=$user['name']?>
          </div>
      </div>
      <div class="row">
          <div class="col-sm-4">
              हस्ते: स्वत:
          </div>
          <div class="col-sm-4">
              मोहल्ला: <?php echo $this->db->get_where('n_zones',array('id'=>$user['zone']))->row()->name?>
          </div>
          <div class="col-sm-4">
              घर नं: <?=$user['house_no']?>
          </div>
      </div>
      <div class="row">
          <div class="col-sm-12">
              एकूण रुपये <?=$bill['total']?> फक्त, अक्षरी(<?=$bill['word']?>)
          </div>
      </div>
      <div class="row">
          <div class="col-sm-12">
              सन  करिता खालील तपशील दिल्याप्रमाणे वसूल झाले
          </div>
      </div>
          <h3 style="text-align: center">वसुलीचा तपशील-<?=$year?></h3>
      <div class="row">
          <table class="table table-striped table-bordered">
              <thead>
                  <th>अ.क्र.</th>
                  <th>कराचा तपशील</th>
                  <th>वर्ष</th>
                  <th>एकूण कर </th>
                 
                  <th>कर भरला रुपये </th>
                  <th>चालू बाकी </th>
              </thead>
              <tbody>
                  <?php
  $pending=$total=$new=0;
                  $r=0;  foreach($bill['tax'] as $a){
                      
                      $total=$total+$a['total'];
                      $pending=$pending+$a['pending'];
                      $new=$new+$a['new'];
                      
                      ?>
                                                      <tr>
                          <td><?=++$r?></td>
                          <td><?php echo $rr=select($tax_t,array('id'=>$a['tax_id']))[0]['name']?></td>
                          <td><?=$a['year']?></td>
                          <td><?=$a['total']?> रुपये</td>
                          <td><?=$a['new']?> रुपये</td>
                          <td><?=$a['pending']?> रुपये</td>
                      </tr>
                      <?php } ?>
                                                      
                                                  </tbody>
              <tfoot>
                  <tr>
                      <td colspan="3"></td>
                      <td><?=$total?> रुपये</td>
                      <td><?=$new?> रुपये</td>
                      <td><?=$pending?> रुपये </td>
                  </tr>
  
                  <th colspan="3">एकूण वसुली रुपये</th>
                  <th colspan="1"><?=$bill['total']?> रुपये (<?=AmountInWords($bill['total'])?>)</th>
  
  
   <tr>
                  <th colspan="3">एकूण बाकी रुपये</th>
                  <th colspan="1"><?=$pending?> रुपये (<?=AmountInWords($pending)?>)</th>
  <tr>
              </tfoot>
          </table>
      </div>
      <div class="row">
          <div class="col-sm-12" style="text-align: right;">
              <img src="/stamp.png" style="float: right;height:150px;" />
          </div>
      </div>
      <div class="row">
          <div class="col-sm-12" style="text-align: right;">
              वसुली करणाऱ्या अधिकार्याची सही<br/>
               नाव: स्वत:<br />
              नगर परिषद, हिंगोली
          </div>
      </div>
  
  </div>