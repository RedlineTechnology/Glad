<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package _glad
 */

    get_header(); ?>

    <section class="hero" style="background-image: url(' <?php echo $header_img ?>')">
  		<img id="members-img" src="<?php echo get_stylesheet_directory_uri() ?>/images/members.png">
  		<a class="button" href="/login">Log in</a>
  		<div class="membership-box"></div>
  	</section>

    <div id="page" class="content-area">
  		<main id="main" class="site-main">

  			<?php get_template_part('template-parts/nav-members'); ?>

  			<section class="content">

          <?php
  				while (have_posts()) : the_post();
  					echo '<div class="the-content">';

  						// All The Pages Stuff
  						the_content(); ?>

                <form action="#" method="POST" class="form-hero" id="submit_comp" autocomplete="off" enctype="multipart/form-data">

                  <input type="hidden" name="action" value="updatecomp">
                  <input type="hidden" name="user_id" id="user_id" value="<?php echo get_current_user_id(); ?>">
                  <input type="hidden" name="post_id" id="post_id" value="0">

                  <h3>Aircraft</h3>
                  <div class="form-section primary">

                    <?php // Aircraft Primary Data ?>

                    <!-- <label for="type">Aircraft Type:</label>
                    <select id="type" name="type">
                      <option selected="selected" value=""></option>
                      <option value="">Hawker 400XPR</option>
                      <option value="">ADAM A700</option>
                      <option value="">Airbus ACJ318</option>
                      <option value="">Airbus ACJ319</option>
                      <option value="">Airbus ACJ320</option>
                      <option value="">Astra 1125</option>
                      <option value="">Astra 1125Sp</option>
                      <option value="">Astra 1125Spx</option>
                      <option value="">Avanti EVO</option>
                      <option value="">Avanti Ii</option>
                      <option value="">Avanti P180</option>
                      <option value="">Beechjet 400a</option>
                      <option value="">Boeing Bbj</option>
                      <option value="">Boeing Bbj2</option>
                      <option value="">Boeing Bbj3</option>
                      <option value="">Caravan</option>
                      <option value="">Caravan 208</option>
                      <option value="">Caravan 208B</option>
                      <option value="">CARAVAN 208B EX</option>
                      <option value="">Challenger 601</option>
                      <option value="">Challenger 890</option>
                      <option value="">Challenger 300</option>
                      <option value="">CHALLENGER 350</option>
                      <option value="">Challenger 601-3R</option>
                      <option value="">Challenger 604</option>
                      <option value="">Challenger 605</option>
                      <option value="">CHALLENGER 650</option>
                      <option value="">Challenger 850</option>
                      <option value="">Challenger 870</option>
                      <option value="">Citation III</option>
                      <option value="">Citation Jet</option>
                      <option value="">Citation Longitude</option>
                      <option value="">Citation S/II</option>
                      <option value="">Citation VI</option>
                      <option value="">Citation X Elite</option>
                      <option value="">Citation 525</option>
                      <option value="">Citation Bravo</option>
                      <option value="">Citation Cj1</option>
                      <option value="">Citation Cj1+</option>
                      <option value="">Citation Cj2</option>
                      <option value="">Citation Cj2+</option>
                      <option value="">Citation Cj3</option>
                      <option value="">CITATION CJ3+</option>
                      <option value="">Citation Cj4</option>
                      <option value="">Citation Encore</option>
                      <option value="">Citation Encore+</option>
                      <option value="">Citation Excel</option>
                      <option value="">CITATION II</option>
                      <option value="">CITATION LATITUDE</option>
                      <option value="">CITATION M2</option>
                      <option value="">Citation Mustang</option>
                      <option value="">Citation Sovereign</option>
                      <option value="">Citation Sovereign+</option>
                      <option value="">Citation Ultra</option>
                      <option value="">Citation V</option>
                      <option value="">Citation Vii</option>
                      <option value="">Citation X</option>
                      <option value="">Citation X+</option>
                      <option value="">Citation Xls</option>
                      <option value="">Citation Xls+</option>
                      <option value="">Conquest</option>
                      <option value="">D-Jet</option>
                      <option value="">E-1000</option>
                      <option value="">ECLIPSE 550</option>
                      <option value="">Eclipse Ea500</option>
                      <option value="">Embraer Legacy 450</option>
                      <option value="">Embraer Legacy 500</option>
                      <option value="">EMBRAER LEGACY 500</option>
                      <option value="">Embraer Legacy 600</option>
                      <option value="">EMBRAER LEGACY 650</option>
                      <option value="">Embraer Legacy Shuttle</option>
                      <option value="">Embraer Lineage 1000</option>
                      <option value="">Embraer Phenom 100</option>
                      <option value="">Embraer Phenom 300</option>
                      <option value="">Falcon 10</option>
                      <option value="">Falcon 100</option>
                      <option value="">Falcon 20</option>
                      <option value="">Falcon 200</option>
                      <option value="">Falcon 2000EX</option>
                      <option value="">Falcon 20F</option>
                      <option value="">Falcon 2000</option>
                      <option value="">Falcon 2000Dx</option>
                      <option value="">Falcon 2000Ex</option>
                      <option value="">Falcon 2000Ex Easy</option>
                      <option value="">Falcon 2000Lx</option>
                      <option value="">FALCON 2000LXS</option>
                      <option value="">FALCON 2000S</option>
                      <option value="">Falcon 50</option>
                      <option value="">Falcon 50Ex</option>
                      <option value="">Falcon 5x</option>
                      <option value="">Falcon 7X</option>
                      <option value="">Falcon 8X</option>
                      <option value="">Falcon 900</option>
                      <option value="">Falcon 900B</option>
                      <option value="">Falcon 900C</option>
                      <option value="">Falcon 900Dx</option>
                      <option value="">Falcon 900Ex</option>
                      <option value="">FALCON 900EX EASy</option>
                      <option value="">Falcon 900Lx</option>
                      <option value="">Galaxy</option>
                      <option value="">Global 8000</option>
                      <option value="">Global 5000</option>
                      <option value="">GLOBAL 6000</option>
                      <option value="">GLOBAL 7000</option>
                      <option value="">Global Express</option>
                      <option value="">Global Express Xrs</option>
                      <option value="">Grand Caravan</option>
                      <option value="">Gulfstream G-600</option>
                      <option value="">Gulfstream G-650ER</option>
                      <option value="">Gulfstream II</option>
                      <option value="">Gulfstream III</option>
                      <option value="">Gulfstream G-100</option>
                      <option value="">Gulfstream G-150</option>
                      <option value="">Gulfstream G-200</option>
                      <option value="">GULFSTREAM G-280</option>
                      <option value="">Gulfstream G-300</option>
                      <option value="">Gulfstream G-350</option>
                      <option value="">Gulfstream G-400</option>
                      <option value="">Gulfstream G-450</option>
                      <option value="">Gulfstream G-500</option>
                      <option value="">Gulfstream G-550</option>
                      <option value="">Gulfstream G-650</option>
                      <option value="">Gulfstream G-Iv</option>
                      <option value="">Gulfstream G-Ivsp</option>
                      <option value="">Gulfstream G-V</option>
                      <option value="">Hawker 400XPR</option>
                      <option value="">Hawker 700</option>
                      <option value="">HAWKER 1000A</option>
                      <option value="">HAWKER 125-1A</option>
                      <option value="">Hawker 4000</option>
                      <option value="">Hawker 400Xp</option>
                      <option value="">Hawker 750</option>
                      <option value="">Hawker 800A</option>
                      <option value="">Hawker 800B</option>
                      <option value="">Hawker 800Xp</option>
                      <option value="">Hawker 800Xpi</option>
                      <option value="">Hawker 850Xp</option>
                      <option value="">Hawker 900Xp</option>
                      <option value="">HONDAJET HA-420</option>
                      <option value="">K-350</option>
                      <option value="">King Air 250EP</option>
                      <option value="">King Air 350ER</option>
                      <option value="">King Air 350HW</option>
                      <option value="">King Air 350iER</option>
                      <option value="">King Air F90</option>
                      <option value="">KING AIR 250</option>
                      <option value="">KING AIR 300</option>
                      <option value="">KING AIR 300LW</option>
                      <option value="">King Air 350</option>
                      <option value="">KING AIR 350C</option>
                      <option value="">King Air 350I</option>
                      <option value="">King Air 350Ic</option>
                      <option value="">King Air B200</option>
                      <option value="">King Air B200Gt</option>
                      <option value="">King Air B200Se</option>
                      <option value="">KING AIR C90</option>
                      <option value="">King Air C90B</option>
                      <option value="">King Air C90Gt</option>
                      <option value="">King Air C90Gti</option>
                      <option value="">King Air C90Gtx</option>
                      <option value="">King Air C90Se</option>
                      <option value="">Kodiak 100</option>
                      <option value="">Lear 20 Series</option>
                      <option value="">Lear 55</option>
                      <option value="">Learjet 36</option>
                      <option value="">LEARJET 31</option>
                      <option value="">Learjet 31A</option>
                      <option value="">LEARJET 35A</option>
                      <option value="">Learjet 40</option>
                      <option value="">Learjet 40Xr</option>
                      <option value="">Learjet 45</option>
                      <option value="">Learjet 45Xr</option>
                      <option value="">Learjet 60</option>
                      <option value="">Learjet 60Xr</option>
                      <option value="">LEARJET 70</option>
                      <option value="">Learjet 75</option>
                      <option value="">Nextant 400Xti</option>
                      <option value="">Nextant G90XT</option>
                      <option value="">Other Jet</option>
                      <option value="">Other Turbo-prop</option>
                      <option value="">Phenom 100E</option>
                      <option value="">Pilatus PC-24</option>
                      <option value="">Pilatus Pc-12</option>
                      <option value="">Pilatus PC-12 NG</option>
                      <option value="">PILATUS PC-12/45</option>
                      <option value="">Pilatus PC-12/47</option>
                      <option value="">Piper Cheyenne</option>
                      <option value="">Piper Meridian</option>
                      <option value="">Premier I</option>
                      <option value="">Premier Ia</option>
                      <option value="">Socata Tbm-700a</option>
                      <option value="">Socata Tbm-700B</option>
                      <option value="">Socata Tbm-700C1</option>
                      <option value="">Socata Tbm-700C2</option>
                      <option value="">Socata Tbm-850</option>
                      <option value="">Socata Tbm-900</option>
                      <option value="">Stratos-714</option>
                      <option value="">Supersonic Business Jet</option>
                      <option value="">Swearingen SJ30-2</option>
                      <option value="">SyberJet SJ30i</option>
                      <option value="">Vision SF-50</option>
                      <option value="">Westwind</option>
                    </select> -->

                    <div class="form-row">
                      <div class="autocomplete">
                        <input type="text" name="make" id="make" placeholder="MAKE">
                      </div>
                      <input type="text" name="model" id="model" placeholder="MODEL">
                      <div class="select-wrapper">
                        <label for="type_engine">Type:</label>
                        <select id="type_engine" name="aircraft">
                          <option value=""></option>
                          <option value="3">Jet</option>
                          <option value="14">Single-Engine Piston</option>
                          <option value="33">Twin-Engine Piston</option>
                          <option value="15">Multi-Engine Piston</option>
                          <option value="4">Turboprop</option>
                          <option value="2">Helicopter</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-row">
                      <input type="text" name="serialnumber" id="serialnumber" placeholder="S/N">
                      <input type="text" name="registration" id="registration" placeholder="Registration">
                      <input type="number" name="year_mfr" id="year_mfr" placeholder="Year MFR">
                      <input type="number" name="year_del" id="year_del" placeholder="Year Delivery">
                    </div>
                  </div>
                  <h3>Transactional Info</h3>
                  <div class="form-section">

                  <?php // Transactional Data ?>
                  <!-- <div class="form-row">
                    <div class="radio-wrapper">
                      <label>Market Status: </label>
                      <div>
                        <input type="radio" name="marketstatus" id="status_pending" value="55">
                        <label for="status_pending">Deal Pending</label>
                      </div>
                      <div>
                        <input type="radio" name="marketstatus" id="status_contract" value="8">
                        <label for="status_contract">Under Contract</label>
                      </div>
                      <div>
                        <input type="radio" name="marketstatus" id="status_sold" value="5">
                        <label for="status_sold">Sold</label>
                      </div>
                      <div>
                        <input type="radio" name="marketstatus" id="status_off" value="30">
                        <label for="status_off">Withdrawn (Please state reason)</label>
                      </div>
                    </div>
                    <textarea name="status_notes" id="status_notes" rows="2" cols="40" placeholder="Additional Notes"></textarea>
                  </div> -->

                  <div class="form-row">
                    <div>
                      <label for="date_listed">Date Listed:</label>
                      <input type="date" name="date_listed" id="date_listed" placeholder="Date Listed">
                    </div>
                    <div>
                      <label for="date_sold">Date Sold:</label>
                      <input type="date" name="date_sold" id="date_sold" placeholder="Date Sold">
                    </div>
                  </div>
                  <div class="form-row">
                    <!-- <input type="number" name="days_mkt" id="days_mkt" placeholder="Days on Market"> -->
                    <input type="text" name="price_ask" id="price_ask" placeholder="Asking Price">
                    <input type="text" name="price_sell" id="price_sell" placeholder="Selling Price">
                  </div>
                  <div class="form-row">
                    <div class="radio-wrapper">
                      <label>Were You Directly Involved in the Transaction?</label>
                      <div>
                        <input type="radio" name="direct" id="direct_yes" value="yes">
                        <label for="direct_yes">Yes</label>
                      </div>
                      <div>
                        <input type="radio" name="direct" id="direct_no" value="no">
                        <label for="direct_no">No</label>
                      </div>
                    </div>
                  </div>
                </div>
                <h3>Technical Info</h3>
                <div class="form-section">

                  <?php // Airframe ?>
                  <div class="form-row title">
                    <label>Airframe: </label>
                  </div>
                  <div class="form-row">
                    <input type="number" name="airframe_time" id="airframe_time" placeholder="Airframe Hours">
                    <input type="number" name="airframe_cycles" id="airframe_cycles" placeholder="Cycles / Landings">
                    <div class="select-wrapper">
                      <label for="airframe_program">Mx Program:</label>
                      <select name="airframe_program" id="airframe_program">
                        <option selected="selected" value="">None</option>
                        <option value="jssi">JSSI Tip to Tail</option>
                        <option value="msg">MSG-3</option>
                        <option value="proparts">ProParts</option>
                        <option value="plus">Support Plus+</option>
                        <option value="other">Other</option>
                      </select>
                    </div>
                  </div>

                  <?php // Engines ?>
                  <div class="form-row title">
                    <label>Engines: </label>
                  </div>
                  <div class="form-row">
                    <input type="text" name="engine1_hours" id="engine1_hours" placeholder="Engine 1 Hours">
                    <input type="text" name="engine2_hours" id="engine2_hours" placeholder="Engine 2 Hours">
                    <input type="text" name="engine3_hours" id="engine3_hours" placeholder="Engine 3 Hours">

                    <div class="select-wrapper">
                      <select name="engine_time" id="engine_time">
                        <option value="ttsn">TTSN</option>
                        <option value="tsoh">TSOH</option>
                        <option value="tcso">TCSO</option>
                        <option value="tshi">TSHI</option>
                        <option value="tcsh">TCSH</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-row">
                    <input type="text" name="engine1_cycles" id="engine1_cycles" placeholder="Engine 1 Cycles">
                    <input type="text" name="engine2_cycles" id="engine2_cycles" placeholder="Engine 2 Cycles">
                    <input type="text" name="engine3_cycles" id="engine3_cycles" placeholder="Engine 3 Cycles">

                    <div class="select-wrapper" style="opacity:0;">
                      <select name="dummy" id="dummy">
                        <option value="">None</option>
                      </select>
                    </div>
                  </div>

                  <div class="form-row">

                    <div class="select-wrapper">
                      <label for="engine_program">Engine Program:</label>
                      <select name="engine_program" id="engine_program">
                        <option selected="selected" value="">None</option>
                        <option value="cmsp">CMSP</option>
                        <option value="cc">CorporateCare</option>
                        <option value="cce">CorporateCare Enhanced</option>
                        <option value="csp">CSP</option>
                        <option value="cspgold">CSP Gold</option>
                        <option value="eap">EAP Comprehensive</option>
                        <option value="emc2">EMC2</option>
                        <option value="new">EngiNEWity Citation Engine Program</option>
                        <option value="esp1">ESP</option>
                        <option value="esp2">ESP Gold</option>
                        <option value="esp3">ESP Gold Flex</option>
                        <option value="esp4">ESP Gold Lite</option>
                        <option value="esp5">ESP Gold Lite Flex</option>
                        <option value="esp6">ESP Platinum</option>
                        <option value="esp7">ESP Silver</option>
                        <option value="esp8">ESP Silver Flex</option>
                        <option value="esp9">ESP Silver Lite</option>
                        <option value="fha">FHA</option>
                        <option value="fmp">FMP Maintenance</option>
                        <option value="jssi01">JSSI</option>
                        <option value="jssi02">JSSI - Complete</option>
                        <option value="jssi03">JSSI - Essential</option>
                        <option value="jssi04">JSSI - Essential LLC</option>
                        <option value="jssi05">JSSI - Essential Select</option>
                        <option value="jssi06">JSSI - Platinum</option>
                        <option value="jssi07">JSSI - Premium</option>
                        <option value="jssi08">JSSI - Premium Plus</option>
                        <option value="jssi09">JSSI - Select</option>
                        <option value="jssi10">JSSI - Term</option>
                        <option value="jssi11">JSSI - Unscheduled</option>
                        <option value="jssi12">JSSI+</option>
                        <option value="mcph">Maintenance Cost Per Hour (MCPH)</option>
                        <option value="msp">MSP</option>
                        <option value="mspgold">MSP Gold</option>
                        <option value="point">On-Point Solutions Program</option>
                        <option value="pbh">PBH</option>
                        <option value="pa">Power Advantage</option>
                        <option value="pap">Power Advantage Plus</option>
                        <option value="pbhpower">Powerplan Pay-By-Hour</option>
                        <option value="smart">Smart Parts Engine</option>
                        <option value="smarter">Smart Parts Plus</option>
                        <option value="tap">TAP</option>
                        <option value="tapa">TAP - Advantage</option>
                        <option value="tapab">TAP - Advantage Blue</option>
                        <option value="tapac">TAP - Advantage Blue Progressive</option>
                        <option value="tapad">TAP - Advantage Elite</option>
                        <option value="tapb">TAP - Blue</option>
                        <option value="tape">TAP - Elite</option>
                        <option value="tapep">TAP - Elite Progressive</option>
                        <option value="tapp">TAP - Preferred</option>
                        <option value="ccc">Triple Crown</option>
                        <option value="vmaxgold">VMAX Gold Program</option>
                        <option value="vmax">VMAX Program</option>
                        <option value="other">Unknown</option>
                      </select>
                    </div>

                    <div class="select-wrapper">
                      <label for="engine_coverage">Program Coverage:</label>
                      <select name="engine_coverage" id="engine_coverage">
                        <option selected="selected" value="100">100%</option>
                        <option value="99">99%</option>
                        <option value="98">98%</option>
                        <option value="97">97%</option>
                        <option value="96">96%</option>
                        <option value="95">95%</option>
                        <option value="94">94%</option>
                        <option value="93">93%</option>
                        <option value="92">92%</option>
                        <option value="91">91%</option>
                        <option value="90">90%</option>
                        <option value="89">89%</option>
                        <option value="88">88%</option>
                        <option value="87">87%</option>
                        <option value="86">86%</option>
                        <option value="85">85%</option>
                        <option value="84">84%</option>
                        <option value="83">83%</option>
                        <option value="82">82%</option>
                        <option value="81">81%</option>
                        <option value="80">80%</option>
                        <option value="79">79%</option>
                        <option value="78">78%</option>
                        <option value="77">77%</option>
                        <option value="76">76%</option>
                        <option value="75">75%</option>
                        <option value="74">74%</option>
                        <option value="73">73%</option>
                        <option value="72">72%</option>
                        <option value="71">71%</option>
                        <option value="70">70%</option>
                        <option value="69">69%</option>
                        <option value="68">68%</option>
                        <option value="67">67%</option>
                        <option value="66">66%</option>
                        <option value="65">65%</option>
                        <option value="64">64%</option>
                        <option value="63">63%</option>
                        <option value="62">62%</option>
                        <option value="61">61%</option>
                        <option value="60">60%</option>
                        <option value="59">59%</option>
                        <option value="58">58%</option>
                        <option value="57">57%</option>
                        <option value="56">56%</option>
                        <option value="55">55%</option>
                        <option value="54">54%</option>
                        <option value="53">53%</option>
                        <option value="52">52%</option>
                        <option value="51">51%</option>
                        <option value="50">50%</option>
                        <option value="49">49%</option>
                        <option value="48">48%</option>
                        <option value="47">47%</option>
                        <option value="46">46%</option>
                        <option value="45">45%</option>
                        <option value="44">44%</option>
                        <option value="43">43%</option>
                        <option value="42">42%</option>
                        <option value="41">41%</option>
                        <option value="40">40%</option>
                        <option value="39">39%</option>
                        <option value="38">38%</option>
                        <option value="37">37%</option>
                        <option value="36">36%</option>
                        <option value="35">35%</option>
                        <option value="34">34%</option>
                        <option value="33">33%</option>
                        <option value="32">32%</option>
                        <option value="31">31%</option>
                        <option value="30">30%</option>
                        <option value="29">29%</option>
                        <option value="28">28%</option>
                        <option value="27">27%</option>
                        <option value="26">26%</option>
                        <option value="25">25%</option>
                        <option value="24">24%</option>
                        <option value="23">23%</option>
                        <option value="22">22%</option>
                        <option value="21">21%</option>
                        <option value="20">20%</option>
                        <option value="19">19%</option>
                        <option value="18">18%</option>
                        <option value="17">17%</option>
                        <option value="16">16%</option>
                        <option value="15">15%</option>
                        <option value="14">14%</option>
                        <option value="13">13%</option>
                        <option value="12">12%</option>
                        <option value="11">11%</option>
                        <option value="10">10%</option>
                        <option value="9">9%</option>
                        <option value="8">8%</option>
                        <option value="7">7%</option>
                        <option value="6">6%</option>
                        <option value="5">5%</option>
                        <option value="4">4%</option>
                        <option value="3">3%</option>
                        <option value="2">2%</option>
                        <option value="1">1%</option>
                      </select>
                    </div>
                  </div>

                  <?php // APU ?>
                  <div class="form-row title">
                    <label>APU: </label>
                  </div>
                  <div class="form-row">
                    <input type="text" name="apu_model" id="apu_model" placeholder="APU Model">
                    <input type="text" name="apu_hours" id="apu_hours" placeholder="APU Hours">
                    <div class="radio-wrapper">
                      <label for="apu_program">MSP</label>
                      <div>
                        <input type="radio" name="apu_program" id="apu_program_yes" value="yes">
                        <label for="apu_program_yes">Yes</label>
                      </div>
                      <div>
                        <input type="radio" name="apu_program" id="apu_program_no" value="no">
                        <label for="apu_program_no">No</label>
                      </div>
                    </div>
                  </div>
                  <div class="form-row">
                    <input type="text" name="fms" id="fms" placeholder="Flight Management System">
                  </div>

                  <!-- <label>Year of Last Engine Shop Visit (Calendar Limited Only):</label>
                  <label for="shop_engine1">Engine 1</label>
                  <select name="shop_engine1" id="shop_engine1">
                    <option value=""></option>
                    <option value="1990">1990</option>
                    <option value="1991">1991</option>
                    <option value="1992">1992</option>
                    <option value="1993">1993</option>
                    <option value="1994">1994</option>
                    <option value="1995">1995</option>
                    <option value="1996">1996</option>
                    <option value="1997">1997</option>
                    <option value="1998">1998</option>
                    <option value="1999">1999</option>
                    <option value="2000">2000</option>
                    <option value="2001">2001</option>
                    <option value="2002">2002</option>
                    <option value="2003">2003</option>
                    <option value="2004">2004</option>
                    <option value="2005">2005</option>
                    <option value="2006">2006</option>
                    <option value="2007">2007</option>
                    <option value="2008">2008</option>
                    <option value="2009">2009</option>
                    <option value="2010">2010</option>
                    <option value="2011">2011</option>
                    <option value="2012">2012</option>
                    <option value="2013">2013</option>
                    <option value="2014">2014</option>
                    <option value="2015">2015</option>
                    <option value="2016">2016</option>
                    <option value="2017">2017</option>
                    <option value="2018">2018</option>
                    <option value="2019">2019</option>
                    <option value="2020">2020</option>
                  </select>

                  <label for="shop_engine1">Engine 2</label>
                  <select name="shop_engine2" id="shop_engine2">
                    <option value=""></option>
                    <option value="1990">1990</option>
                    <option value="1991">1991</option>
                    <option value="1992">1992</option>
                    <option value="1993">1993</option>
                    <option value="1994">1994</option>
                    <option value="1995">1995</option>
                    <option value="1996">1996</option>
                    <option value="1997">1997</option>
                    <option value="1998">1998</option>
                    <option value="1999">1999</option>
                    <option value="2000">2000</option>
                    <option value="2001">2001</option>
                    <option value="2002">2002</option>
                    <option value="2003">2003</option>
                    <option value="2004">2004</option>
                    <option value="2005">2005</option>
                    <option value="2006">2006</option>
                    <option value="2007">2007</option>
                    <option value="2008">2008</option>
                    <option value="2009">2009</option>
                    <option value="2010">2010</option>
                    <option value="2011">2011</option>
                    <option value="2012">2012</option>
                    <option value="2013">2013</option>
                    <option value="2014">2014</option>
                    <option value="2015">2015</option>
                    <option value="2016">2016</option>
                    <option value="2017">2017</option>
                    <option value="2018">2018</option>
                    <option value="2019">2019</option>
                    <option value="2020">2020</option>
                  </select>

                  <label for="shop_engine1">Engine 3</label>
                  <select name="shop_engine3" id="shop_engine3">
                    <option value=""></option>
                    <option value="1990">1990</option>
                    <option value="1991">1991</option>
                    <option value="1992">1992</option>
                    <option value="1993">1993</option>
                    <option value="1994">1994</option>
                    <option value="1995">1995</option>
                    <option value="1996">1996</option>
                    <option value="1997">1997</option>
                    <option value="1998">1998</option>
                    <option value="1999">1999</option>
                    <option value="2000">2000</option>
                    <option value="2001">2001</option>
                    <option value="2002">2002</option>
                    <option value="2003">2003</option>
                    <option value="2004">2004</option>
                    <option value="2005">2005</option>
                    <option value="2006">2006</option>
                    <option value="2007">2007</option>
                    <option value="2008">2008</option>
                    <option value="2009">2009</option>
                    <option value="2010">2010</option>
                    <option value="2011">2011</option>
                    <option value="2012">2012</option>
                    <option value="2013">2013</option>
                    <option value="2014">2014</option>
                    <option value="2015">2015</option>
                    <option value="2016">2016</option>
                    <option value="2017">2017</option>
                    <option value="2018">2018</option>
                    <option value="2019">2019</option>
                    <option value="2020">2020</option>
                  </select> -->

                </div>
                <h3>Condition</h3>
                <div class="form-section">

                  <?php // Inspections ?>
                  <div class="form-row title">
                    <label>Inspections: </label>
                  </div>
                  <div class="form-row">
                    <input type="text" name="inspections_cw" id="inspections_cw" placeholder="Inspections C/W and Date C/W">
                    <input type="text" name="inspections_due" id="inspections_due" placeholder="Inspections Due and Date Due">
                  </div>

                  <?php // Interior ?>
                  <div class="form-row title">
                    <label>Paint: </label>
                  </div>
                  <div class="form-row">
                    <div class="select-wrapper">
                      <label>Year</label>
                      <select name="paint_year" id="paint_year">
                        <option value=""></option>
                        <option value="1990">1990</option>
                        <option value="1991">1991</option>
                        <option value="1992">1992</option>
                        <option value="1993">1993</option>
                        <option value="1994">1994</option>
                        <option value="1995">1995</option>
                        <option value="1996">1996</option>
                        <option value="1997">1997</option>
                        <option value="1998">1998</option>
                        <option value="1999">1999</option>
                        <option value="2000">2000</option>
                        <option value="2001">2001</option>
                        <option value="2002">2002</option>
                        <option value="2003">2003</option>
                        <option value="2004">2004</option>
                        <option value="2005">2005</option>
                        <option value="2006">2006</option>
                        <option value="2007">2007</option>
                        <option value="2008">2008</option>
                        <option value="2009">2009</option>
                        <option value="2010">2010</option>
                        <option value="2011">2011</option>
                        <option value="2012">2012</option>
                        <option value="2013">2013</option>
                        <option value="2014">2014</option>
                        <option value="2015">2015</option>
                        <option value="2016">2016</option>
                        <option value="2017">2017</option>
                        <option value="2018">2018</option>
                        <option value="2019">2019</option>
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                      </select>
                    </div>

                    <div class="select-wrapper">
                      <label>Condition</label>
                      <select name="paint_condition" id="paint_condition">
                        <option value=""></option>
                        <option value="1">Needs to be Redone</option>
                        <option value="2">Major Wear</option>
                        <option value="3">Detail Needed</option>
                        <option value="4">Minimal Wear</option>
                        <option value="5">Like-New</option>
                      </select>
                    </div>

                    <input type="text" name="paint_by" id="paint_by" placeholder="Painted By">
                  </div>

                  <div class="form-row title">
                    <label>Interior: </label>
                  </div>
                  <div class="form-row">
                    <div class="select-wrapper">
                      <label>Year</label>
                      <select name="interior_year" id="interior_year">
                        <option value=""></option>
                        <option value="1990">1990</option>
                        <option value="1991">1991</option>
                        <option value="1992">1992</option>
                        <option value="1993">1993</option>
                        <option value="1994">1994</option>
                        <option value="1995">1995</option>
                        <option value="1996">1996</option>
                        <option value="1997">1997</option>
                        <option value="1998">1998</option>
                        <option value="1999">1999</option>
                        <option value="2000">2000</option>
                        <option value="2001">2001</option>
                        <option value="2002">2002</option>
                        <option value="2003">2003</option>
                        <option value="2004">2004</option>
                        <option value="2005">2005</option>
                        <option value="2006">2006</option>
                        <option value="2007">2007</option>
                        <option value="2008">2008</option>
                        <option value="2009">2009</option>
                        <option value="2010">2010</option>
                        <option value="2011">2011</option>
                        <option value="2012">2012</option>
                        <option value="2013">2013</option>
                        <option value="2014">2014</option>
                        <option value="2015">2015</option>
                        <option value="2016">2016</option>
                        <option value="2017">2017</option>
                        <option value="2018">2018</option>
                        <option value="2019">2019</option>
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                      </select>
                    </div>

                    <div class="select-wrapper">
                      <label>Condition</label>
                      <select name="interior_condition" id="interior_condition">
                        <option value=""></option>
                        <option value="1">Needs Replacement</option>
                        <option value="2">Major Wear</option>
                        <option value="3">Moderate Wear</option>
                        <option value="4">Minimal Wear</option>
                        <option value="5">Like-New</option>
                      </select>
                    </div>

                    <input type="text" name="interior_by" id="interior_by" placeholder="Refurbished By">
                  </div>

                  <?php // Condition ?>

                  <div class="form-row">
                    <div class="radio-wrapper">
                      <label for="compliant">2020 Compliant?</label>
                      <div>
                        <input type="radio" name="compliant" id="compliant_yes" value="yes">
                        <label for="compliant_yes">Yes</label>
                      </div>
                      <div>
                        <input type="radio" name="compliant" id="compliant_no" value="no">
                        <label for="compliant_no">No</label>
                      </div>
                    </div>
                    <div class="radio-wrapper">
                      <label for="damage">Damage?</label>
                      <div>
                        <input type="radio" name="damage" id="damage_yes" value="yes">
                        <label for="damage_yes">Yes</label>
                      </div>
                      <div>
                        <input type="radio" name="damage" id="damage_no" value="no">
                        <label for="damage_no">No</label>
                      </div>
                    </div>
                    <div class="radio-wrapper">
                      <label for="damage_337">Was a Form 337 Filed?</label>
                      <div>
                        <input type="radio" name="damage_337" id="damage_337_yes" value="yes">
                        <label for="damage_337_yes">Yes</label>
                      </div>
                      <div>
                        <input type="radio" name="damage_337" id="damage_337_no" value="no">
                        <label for="damage_337_no">No</label>
                      </div>
                    </div>
                  </div>
                </div>
                <h3>Additional Information</h3>
                <div class="form-section">
                  <div class="form-row">
                    <input type="number" name="pax" id="pax" placeholder="Passengers">
                  </div>
                  <div class="form-row">
                    <textarea name="notes" id="notes" rows="10" cols="50" placeholder="Additional Notes"></textarea>
                    <div class="button-wrapper">
                      <button id="submit" value="updatecomp">Submit...</button>
                    </div>
                  </div>
                </div>

              </form> <?php

  					echo '</div>';
  				endwhile;
  				?>

      </section>

    </main><!-- #main -->
    </div><!-- #primary -->

    <?php wp_enqueue_script( 'autocomplete', get_template_directory_uri() . '/js/autocomplete.min.js', array('jquery'), '20210201', true); ?>

    <script>
      jQuery(document).ready( function($){
        autocomplete(document.getElementById("make"), makes);

        $.ajaxSetup({cache:false});

        $('#submit_comp').submit( function() {
          $.ajax({
              url: 'https://glada.aero/wp-admin/admin-ajax.php',
              type: 'POST',
              data: $(this).find(':input').filter( function(index, element) {
                      return $(element).val() != '';
                    }).serialize(),
              dataType: 'json',
              beforeSend: function( xhr ) {
                $('#submit_comp #submit').addClass('loading').text('Sending...');
              },
              success: function( data ) {
                $('#submit_comp #submit').removeClass('loading').text('Done!');
                $('.form-hero').html('<div><h1>Success!</h1><p>Your listing has been updated.<br>You will be redirected back to the Dashboard in 5 seconds.</p></div>');

                setTimeout(function() {
                    location.replace("https://glada.aero/members");
                }, 4000);
              }
          });
          return false;
        });
      });
    </script>

    <?php

    get_footer();
