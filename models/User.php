<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;
use app\models\Collection;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $login
 * @property string $password
 * @property string $birthdate
 * @property string $email
 * @property string $sex
 * @property int $role_id
 * @property string $authKey
 * @property int $is_blocked
 * @property string $img_url
 *
 * @property Collection[] $collections
 * @property Comment[] $comments
 * @property Like[] $likes
 * @property Notification[] $notifications
 * @property Role $role
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    public $password_repeat;
    public $imageFile;
    const SCENARIO_CREATE_PROFILE_IMAGE = 'create_profile_image';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return [
            [['login', 'password', 'password_repeat', 'birthdate', 'email', 'sex'], 'required'],

            [['role_id', 'is_blocked'], 'integer'],
            [['login', 'password', 'email', 'sex', 'authKey'], 'string', 'max' => 255],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Role::class, 'targetAttribute' => ['role_id' => 'id']],
            [['email'], 'email'],
            [['login'], 'unique'],
            [['email'], 'unique'],
            [['password_repeat'], 'compare', 'compareAttribute' => 'password'],
            [['birthdate'], 'date', 'format' => 'd.m.Y'],
            [['birthdate'], 'compare', 'compareValue' => date('Y-m-d'), 'operator' => '<', 'type' => 'date'],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'on' => self::SCENARIO_CREATE_PROFILE_IMAGE],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Логин',
            'password' => 'Пароль',
            'password_repeat' => 'Повтор пароля',
            'birthdate' => 'Дата рождения',
            'email' => 'Email',
            'sex' => 'Гендер',
            'role_id' => 'Role ID',
            'authKey' => 'Auth Key',
            'is_blocked' => 'Is Blocked',
        ];
    }

    /**
     * Gets query for [[Collections]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCollections()
    {
        return $this->hasMany(Collection::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Likes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLikes()
    {
        return $this->hasMany(Like::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Notifications]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNotifications()
    {
        return $this->hasMany(Notification::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Role]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::class, ['id' => 'role_id']);
    }
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }
    public static function findByLogin($login)
    {
        return self::findOne(['login' => $login]);
    }
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($insert) {
            $this->authKey = Yii::$app->security->generateRandomString(10);
            $this->role_id = Role::findOne(['title' => 'user'])->id;
            $this->password = Yii::$app->security->generatePasswordHash($this->password);
            $this->is_blocked = 0;

        }
        return true;
    }
    public static function getAuthors()
    {
        return User::find()->select('login')->distinct()->from('user')->leftJoin('work', 'work.user_id=user.id')->leftJoin('work_collection', 'work.id = work_collection.work_id')->leftJoin('collection', 'collection.id=work_collection.collection_id')->where(['collection.user_id' => Yii::$app->user->id])->asArray()->indexBy('user.id')->column();
    }
    public static function getImg($id)
    {
        return self::find()->select('img_url')->where(['id' => $id]);
    }
}
// $this->imageFile->saveAs('@web/uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
//             $this->img_url = $this->imageFile->baseName . '.' . $this->imageFile->extension;
