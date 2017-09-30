<?php

namespace app\models;

use Yii;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $content
 * @property string $date
 * @property string $image
 * @property integer $viewed
 * @property integer $user_id
 * @property integer $status
 * @property integer $category_id
 *
 * @property ArticleTag[] $articleTags
 * @property Comment[] $comments
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title','description', 'content'], 'string'],
            [['date'], 'date', 'format' => 'php:Y-m-d'],
            [['date'], 'default', 'value' => date('Y-m-d')],
            [['title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'content' => 'Content',
            'date' => 'Date',
            'image' => 'Image',
            'viewed' => 'Viewed',
            'user_id' => 'User ID',
            'status' => 'Status',
            'category_id' => 'Category ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticleTags()
    {
        return $this->hasMany(ArticleTag::className(), ['article_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['article_id' => 'id']);
    }

    public function saveImage($filename){

        $this->image = $filename;

        return $this->save(false);

    }

    public function deleteImage(){
        $imageUploadModel = new ImageUpload();
        $imageUploadModel->deleteCurrentImage($this->image);
    }

    public function beforeDelete()
    {
        $this->deleteImage();
        return parent::beforeDelete();
    }

    public function getImage(){
        return ($this->image) ? '/uploads/' . $this->image : '/no-image.png';
    }


    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function saveCategory($category_id){

        $category = Category::findOne($category_id);
        if($category != null){
            $this->link('category', $category);
            return true;
        }
        $this->link('category', $category);
    }

    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable('article_tag', ['article_id' => 'id']);
    }

    public function getSelectedTags(){
        $selectedTags = $this->getTags()->select('id')->asArray()->all();
        return ArrayHelper::getColumn($selectedTags,'id');
    }

    public function saveTags($tags){
        if(is_array($tags)){

            ArticleTag::deleteAll(['article_id'=>$this->id]);

            foreach ($tags as $tag_id){
                $tag = Tag::findOne($tag_id);
                $this->link('tags',$tag);
            }
        }
    }

    public function getDate(){
        //Yii::$app->formatter->locale = 'ru-RU';
        return Yii::$app->formatter->asDate($this->date);
    }

    public static function getAll(){
        $query = Article::find();

        $countQuery = clone $query;

        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'pageSize' => 5,
        ]);

        $models = $query
            ->offset($pages->offset) //кол-во записей которые можно выбрать назад
            ->limit($pages->limit)
            ->all();

        $data ['articles'] = $models;
        $data ['pagination'] = $pages;

        return $data;
    }

    public static function getPopular(){
        return Article::find()->orderBy('viewed desc')->all();
    }

    public static function getRecent(){
        return Article::find()->orderBy('date asc')->all();
    }

    public function saveArticle(){
        $this->user_id = Yii::$app->user->id;
        return $this->save();
    }

    public function getComment(){
        return $this->hasMany(Comment::className(),['article_id' => 'id']);
    }

    public function getAuthor(){
        return $this->hasOne(User::className(),['id'=>'user_id']);
    }

    public function viewedCount(){
        $this->viewed+=1;
        return $this->save(false);
    }
}


