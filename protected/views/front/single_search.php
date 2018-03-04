<style type="text/css">
    input:-ms-input-placeholder {
        color:#000;


        text-align:center;
    }

    input::-webkit-input-placeholder {
        color:#000;


        text-align:center;
    }

    input:-moz-placeholder {
        color:#000;


        text-align:center;
    }

    /* firefox 19+ */
    input::-moz-placeholder {
        color:#000;


        text-align:center;
    }
</style>

<div class="search-wraps single-search">

    <div class="search-label-d">
        <h1><?php echo t($home_search_text);?></h1>
        <p><?php echo t($home_search_subtext);?></p>
    </div>

    <div class="search-label-m">
        <h1><?php echo t($home_search_text_mobile);?></h1>
        <p><?php echo t($home_search_subtext_mobile);?></p>
    </div>

    <form method="GET" class="forms-search" id="forms-search" action="<?php echo Yii::app()->createUrl('store/searcharea')?>">
        <div class="search-input-wraps rounded30" style="border-radius:3px;margin-top:60px">
            <div class="row">
                <div class=" border col-sm-10 col-xs-12">
                    <?php echo CHtml::textField('s',$kr_search_adrress,array(
                        'placeholder'=>$placholder_search,
                        'required'=>true

                    ))?>
                </div>

                <div class=" relative border col-sm-2 col-xs-2 Btndsk">
                    <button type="submit" class="btn btn-primary btn-block" style="background-color:#ED1E79;margin-top:-6px;min-width:85px;padding:10px;font-size:14px;margin-right:-12px;">Search</button>
                </div>
            </div>

        </div> <!--search-input-wrap-->
        <div class="row " style="width: 80%; margin: auto;">
            <div class="col col-sm-3"></div>
            <div class="">
                <div class=" Btnsearchres">
                    <button type="submit" align="center" class="btn btn-danger" style="padding:15px;background-color:#ED1E79;margin-top:15px;margin-bottom:;min-width:100%;font-size:16px;font-weight:bold">
                        <i class="fa fa-search  fa-lg"> Search</i></button>  </div>
                <div class="col col-sm-3"></div>
            </div></div>

    </form>

</div> <!--search-wrapper-->