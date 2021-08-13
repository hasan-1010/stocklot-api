<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;
use kartik\file\FileInput;
use common\components\Util;
use dosamigos\tinymce\TinyMce;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use common\models\Category;
use common\models\Brand;
use common\models\Fabric;
use common\models\Measurement;
use common\models\Quality;
use common\models\Color;

/* @var $this yii\web\View */
/* @var $model common\models\BuyerRequest */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="buyer-request-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-4">
            <?php
                $parent_cat = Category::find()->where(['parent_id' => 0])->all();
                $parent_cat_list = ArrayHelper::map($parent_cat, 'id', 'title');
                $sub_cat_list = []; 
                $sub_cat_2_list = [];
                if(!$model->isNewRecord){
                    $sub_category = Category::find()->where(['parent_id' => $model->main_cat_id])->all();
                    $sub_cat_list = ArrayHelper::map($sub_category, 'id', 'title');

                    $sub_category_2 = Category::find()->where(['parent_id' => $model->sub_cat_id])->all();
                    $sub_cat_2_list = ArrayHelper::map($sub_category_2, 'id', 'title');
                }

                $brands = Brand::find()->all();
                $brandList = ArrayHelper::map($brands, 'id', 'title');
                $fabrics = Fabric::find()->all();
                $fabricList = ArrayHelper::map($fabrics, 'id', 'name');
                $measurements = Measurement::find()->all();
                $measurementList = ArrayHelper::map($measurements, 'id', 'name');
                $qualities = Quality::find()->all();
                $qualityList = ArrayHelper::map($qualities, 'id', 'name');
                $colors = Color::find()->all();
                $colorList = ArrayHelper::map($colors, 'id',  function($model){
                    return $model->name;
                });

            ?>
            <?= $form->field($model, 'main_cat_id')->dropDownList($parent_cat_list, [
                'prompt' => 'Select...',
                'onchange'=>'
                    $.post( "'.Yii::$app->urlManager->createUrl('category/subcategory?id=').'"+$(this).val(), function( data ) {
                        
                        $( "select#buyerrequest-sub_cat_id" ).html( data ); 
                        $( "select#buyerrequest-sub_cat_2_id" ).html( "<option>Select...</option>" );          
                    });
                '])->label('Main Category'); 
            ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'sub_cat_id')->dropDownList($sub_cat_list, [
                'prompt' => 'Select...',
                'onchange'=>'
                $.post( "'.Yii::$app->urlManager->createUrl('category/sub2category?id=').'"+$(this).val(), function( data ) {                    
                    $( "select#buyerrequest-sub_cat_2_id" ).html( data );           
                });
    '])->label('Sub Category'); ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'sub_cat_2_id')->dropDownList($sub_cat_2_list, [
                'prompt' => 'Select...'
                ])->label('Sub Category 2');
            ?>
        </div>
    </div>
    
    
    <!-- <hr> -->

    <div class="row">
        <div class="col-md-6">
            <?= $form->field( $model, 'file' )->widget( FileInput::classname(), [
                    'options'       => [ 'accept' => 'image/*' ],
                    'pluginOptions' => [
                        'allowedFileExtensions' => [ 'jpg', 'gif', 'png', 'webp'],
                        'initialPreview'        => [
                            (!$model->isNewRecord) ? (Html::img( Util::getUrlImage( $model->image ), [ 'height' => '200', 'class' => 'image-preview-input' ] )):null
                            //Html::img( Util::getUrlImage( $model->image ), [ 'height' => '200', 'class' => 'image-preview-input' ] )
                        ],
                        'overwriteInitial'      => true,
                        'showUpload'            => false,
                        'browseOnZoneClick'     => true, 
                        'showCaption'           => false,
                    ]
                ] )->label('Image');
            ?>
        </div>
        <div class="col-md-6">
            <?= $form->field( $model, 'description' )->widget( TinyMce::className(), [
                    'options'  => [ 'rows' => 14 ],
                    'language' => 'en',

                    'clientOptions' => [
                        //set br for enter
                        'force_br_newlines' => true,
                        'force_p_newlines'  => false,
                        'forced_root_block' => '',


                        'file_picker_callback' => new JsExpression( "function(cb, value, meta) {
                             var input = document.createElement('input');
                             input.setAttribute('type', 'file');
                             input.setAttribute('accept', 'image/*');
                             
                             // Note: In modern browsers input[type=\"file\"] is functional without 
                             // even adding it to the DOM, but that might not be the case in some older
                             // or quirky browsers like IE, so you might want to add it to the DOM
                             // just in case, and visually hide it. And do not forget do remove it
                             // once you do not need it anymore.
                            
                             input.onchange = function() {
                                   var file = this.files[0];
                               
                                    var reader = new FileReader();
                                reader.onload = function () {
                                    // Note: Now we need to register the blob in TinyMCEs image blob
                                    // registry. In the next release this part hopefully won't be
                                    // necessary, as we are looking to handle it internally.
                                    var id = 'blobid' + (new Date()).getTime();
                                    var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                                    var base64 = reader.result.split(',')[1];
                                    var blobInfo = blobCache.create(id, file, base64);
                                    blobCache.add(blobInfo);
                                    
                                    // call the callback and populate the Title field with the file name
                                    cb(blobInfo.blobUri(), { title: file.name });
                                };
                                reader.readAsDataURL(file);
                             };
                             
                             input.click();
                            }" ),
                        'plugins'              => [
                            "advlist autolink lists link charmap print preview anchor",
                            "searchreplace visualblocks code fullscreen",
                            "insertdatetime media table contextmenu paste image imagetools"
                        ],

                        'menubar'           => [ "insert" ],
                        'automatic_uploads' => true,
                        'file_picker_types' => 'image',

                        'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image imageupload | fontselect | cut copy paste"
                    ]
                ] );

            ?>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'measurement_id')->dropDownList($measurementList, ['prompt' => 'Select...']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'color_id')->dropDownList($colorList, ['prompt' => 'Select...']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'quantity')->textInput() ?>
        </div>
    </div>
    <div class="row">

        <div class="col-md-3">
            <?= $form->field($model, 'quality_id')->dropDownList($qualityList, ['prompt' => 'Select...']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'fabric_id')->dropDownList($fabricList, ['prompt' => 'Select...']) ?>
        </div>
        
        <div class="col-md-3">
            <?= $form->field($model, 'brand_id')->dropDownList($brandList, [
                'prompt' => 'Select...',
                'onchange'=>'
                   if($(this).val() == "11") {                    
                        $(".field-buyerrequest-other_brand").show();
                    }
                    else{
                        $("#buyerrequest-other_brand").val("");
                        $(".field-buyerrequest-other_brand").hide();
                    }
                '
            ]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'other_brand')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    
    <hr>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
