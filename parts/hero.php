<?php  
$heroText = get_field('home_hero_text');
$heroVideo = get_field('hero_video');
$heroDate = get_field('hero_event_date');
$hd = ($heroDate) ? date_intervals_info($heroDate) : '';
$ctr_Month = (isset($hd['months']) && $hd['months']) ? $hd['months'] : '0';
$ctr_Days = (isset($hd['days']) && $hd['days']) ? $hd['days'] : '0';
$ctr_Hours = (isset($hd['hours']) && $hd['hours']) ? $hd['hours'] : '0';

if($heroVideo || $heroText) { ?>
<section id="home-hero">


  <div id="home-banner" class="home-banner">

    <?php if ( isset($heroText['top']) || isset($heroText['middle']) ||  isset($heroText['bottom']) ) { ?>
    <div class="banner-text">
      <div class="inner">
        <?php if ( (isset($heroText['top'])) && $heroText['top']) { ?>
        <div class="t1"><?php echo $heroText['top'] ?></div>
        <?php } ?>
        <?php if ( (isset($heroText['middle'])) && $heroText['middle']) { ?>
        <div class="t2"><?php echo $heroText['middle'] ?></div>
        <?php } ?>
        <?php if ( (isset($heroText['bottom'])) && $heroText['bottom']) { ?>
        <div class="t3" style="animation-delay:.6s"><?php echo $heroText['bottom'] ?></div>
        <?php } ?>
      </div>
    </div>
    <?php } ?>

    <?php if ($heroDate) { ?>
    <div id="countdown" class="animated fadeIn" style="animation-delay:1s">
      <div id="vline"><span></span></div>
      <div class="timer">
        <div class="counttype month">
          <div class="text">MONTHS</div>
          <div class="count"><?php echo $ctr_Month ?></div>
        </div>

        <div class="counttype days">
          <div class="text">DAYS</div>
          <div class="count"><?php echo $ctr_Days ?></div>
        </div>

        <div class="counttype hours">
          <div class="text">HOURS</div>
          <div class="count"><?php echo $ctr_Hours ?></div>
        </div>
      </div>
    </div>
    <?php } ?>

  </div>

</section>
<?php } ?>