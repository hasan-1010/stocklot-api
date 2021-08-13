<?php

use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use common\components\Util;
use dosamigos\tinymce\TinyMce;
use common\models\Category; 
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    
    <div class="row">
        <div class="col-md-8">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?php 
                $categories = Category::find()->orderBy(['parent_id' => SORT_ASC])->all();
                $categoryList = ArrayHelper::map($categories,'id','title');
             ?>
            <?= $form->field($model, 'parent_id')->dropDownList($categoryList,['prompt' => 'No Parent']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field( $model, 'file' )->widget( FileInput::classname(), [
                    'options'       => [ 'accept' => 'image/*' ],
                    'pluginOptions' => [
                        'allowedFileExtensions' => [ 'jpg', 'gif', 'png', 'webp'],
                        'initialPreview'        => [
                            ($model->isNewRecord) ?null:Html::img( Util::getUrlImage( $model->thumb ), [ 'height' => '200', 'class' => 'image-preview-input' ] )
                        ],
                        'overwriteInitial'      => true,
                        'showUpload'            => false,
                        'showCaption'           => false,
                        'browseOnZoneClick'     => true,
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

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
