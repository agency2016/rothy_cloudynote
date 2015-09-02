<section class="main-body-content">
    <div class="container">
        <div class="page-title-container">
            <div class="row-fluid">
                <div class="span12">                 
                    <div class="page-title">
                        <h1 class="text-center">Save Paper Ticker</h1>
                    </div><!-- End of Page Title -->                
                </div><!-- End of bootstrap Page Title span12 -->
            </div><!-- End of feature note row-fluid -->
        </div>

        <div class="contact-us-container"> 
            <div class="row-fluid">
                <div class="span12">
                    <header class="clearfix">
                        <h3 class="text-center" style="color:#000;padding-top:45px;">Did you know?</h3>
                    </header>
                    <div class="about-content clearfix" style="padding:0 20px 20px 20px;">
                        <p>In Australia, we consume about 4.25 million tonnes of paper each year. </p>
                        <p>This equates to around 177 000 trees per year.</p>
                        <p>A single tree accounts for 8 333 odd pieces of A4 paper, but this is just the first cost.</p>
                        <p>It takes up to 90 000 litres of water to produce 1 tonne of paper out of virgin material. There are about 200 000 sheets of A4 paper per tonne, that equates to over 450ml of water for a single sheet of A4 paper. </p>
                        <p>Each tonne of paper produced, would cause around 1.46 tonnes of CO<sub>2</sub> emissions released into the atmosphere. In context, the Family car would have to drive approximately 4,000 kilometres to equal the same CO<sub>2</sub> emissions as 1 tonne of paper.</p>
                        <p>Paper production also creates waste that ends up going into landfills. In Australia, we send about 1.9 million tonnes of paper to landfills per year. Not to mention the additional hazard of toxic inks, dyes and polymers that are potentially carcinogenic when incinerated or buried in landfills.</p>
                        <p style="padding-top:30px; color:#3366FF; ">The CloudeNotes Save Paper Ticker calculates that every CloudeNote sent, is equal to 1 x A4 sheet of paper. With every CloudeNote sent the Ticker below will register your contribution to help eliminate Paper Notes.</p>
                    </div>
                </div>
            </div>  
             <div class="row-fluid">            
                <div class="span12 text-center">
                    <img src="<?php echo base_url( 'resources/images/c-note.png' ); ?>" alt="" />
                    <div style="padding-top:60px;"></div>
                </div>
            </div>

        </div><!-- End of Contact Us form Container -->
    </div><!-- End of bootstrap container class -->
</section><!-- End of main content -->
<div class="saved-ticker">
    <?php
     $this->view('page/include/count-ticker');
    ?>
</div>

