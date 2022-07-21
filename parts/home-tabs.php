<?php  
if(isset($homeTabs) && $homeTabs) { $tab_count = count($homeTabs); ?>
  <section id="hometabs" class="hometabs count-<?php echo $tab_count ?>">
    <div class="outer-wrap">
      <div class="wrapper">
        <div class="inner animated fadeInUp">
          <?php foreach ($homeTabs as $tab) { 
            $link = $tab['link'];
            $tabLink = (isset($link['url']) && $link['url']) ? $link['url'] : 'javascript:void(0)';
            $tabName = (isset($link['title']) && $link['title']) ? $link['title'] : '';
            $tabTarget = (isset($link['target']) && $link['target']) ? $link['target'] : '_self';
            $bgcolor = (isset($tab['bgcolor']) && $tab['bgcolor']) ? $tab['bgcolor'] : '#e9e9e9';
          ?>
          <div class="tab">
            <a href="<?php echo $tabLink ?>" target="<?php echo $tabTarget ?>" style="background:<?php echo $bgcolor ?>"><span><?php echo $tabName ?></span></a>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </section>
<?php } ?>






