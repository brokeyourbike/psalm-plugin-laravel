Feature: Eloquent Relation Types
  Illuminate\Database\Eloquent\Relations have type support

  Background:
    Given I have the following config
      """
      <?xml version="1.0"?>
      <psalm totallyTyped="true">
        <projectFiles>
          <directory name="."/>
          <ignoreFiles> <directory name="../../vendor"/> </ignoreFiles>
        </projectFiles>
        <plugins>
          <pluginClass class="Psalm\LaravelPlugin\Plugin"/>
        </plugins>
      </psalm>
      """
    And I have the following code preamble
      """
      <?php declare(strict_types=1);
      namespace Tests\Psalm\LaravelPlugin\Sandbox;

      use \Illuminate\Database\Eloquent\Builder;
      use \Illuminate\Database\Eloquent\Model;
      use \Illuminate\Database\Eloquent\Relations\HasOne;
      use \Illuminate\Database\Eloquent\Relations\BelongsTo;
      use \Illuminate\Database\Eloquent\Relations\BelongsToMany;
      use \Illuminate\Database\Eloquent\Relations\HasMany;
      use \Illuminate\Database\Eloquent\Relations\HasManyThrough;
      use \Illuminate\Database\Eloquent\Relations\HasOneThrough;
      use \Illuminate\Database\Eloquent\Relations\MorphTo;

      use Tests\Psalm\LaravelPlugin\Models\Comment;
      use Tests\Psalm\LaravelPlugin\Models\Image;
      use Tests\Psalm\LaravelPlugin\Models\Mechanic;
      use Tests\Psalm\LaravelPlugin\Models\Phone;
      use Tests\Psalm\LaravelPlugin\Models\Post;
      use Tests\Psalm\LaravelPlugin\Models\Role;
      use Tests\Psalm\LaravelPlugin\Models\User;
      """

  Scenario: Models can declare one to one relationships
    Given I have the following code
    """
    final class Repository
    {
      /**
      * @psalm-return HasOne<Phone>
      */
      public function getPhoneRelationship(User $user): HasOne {
        return $user->phone();
      }

      /**
      * @psalm-return BelongsTo<User>
      */
      public function getUserRelationship(Phone $phone): BelongsTo {
        return $phone->user();
      }
    }
    """
    When I run Psalm
    Then I see no errors

  Scenario: Models can declare one to many relationships
    Given I have the following code
    """
    final class Repository
    {
      /**
      * @psalm-return BelongsTo<Post>
      */
      public function getPostRelationship(Comment $comment): BelongsTo {
        return $comment->post();
      }

      /**
      * @psalm-return HasMany<Comment>
      */
      public function getCommentsRelationship(Post $post): HasMany {
        return $post->comments();
      }
    }
    """
    When I run Psalm
    Then I see no errors

  Scenario: Models can declare many to many relationships
    Given I have the following code
    """
    final class Repository
    {
      /**
      * @psalm-return BelongsToMany<Role>
      */
      public function getRolesRelationship(User $user): BelongsToMany {
        return $user->roles();
      }

      /**
      * @psalm-return BelongsToMany<User>
      */
      public function getUserRelationship(Role $role): BelongsToMany {
        return $role->users();
      }
    }
    """
    When I run Psalm
    Then I see no errors

  Scenario: Models can declare has through relationships
    Given I have the following code
    """
    final class Repository
    {
      /**
      * @psalm-return HasManyThrough<Mechanic>
      */
      public function getCarsAtMechanicRelationship(User $user): HasManyThrough {
        return $user->carsAtMechanic();
      }

      /**
      * @psalm-return HasOneThrough<User>
      */
      public function getCarsOwner(Mechanic $mechanic): HasOneThrough {
        return $mechanic->carOwner();
      }
    }
    """
    When I run Psalm
    Then I see no errors

  Scenario: Models can declare polymorphic relationships
    Given I have the following code
    """
    final class Repository
    {
      public function getPostsImageDynamicProperty(Post $post): Image {
        return $post->image;
      }

      /**
      * @todo: support for morphTo dynamic property
      * @psalm-return mixed
      */
      public function getImageableProperty(Image $image) {
        return $image->imageable;
      }

      /**
      * @todo: better support for morphTo relationships
      * @psalm-return MorphTo
      */
      public function getImageableRelationship(Image $image): MorphTo {
        return $image->imageable();
      }
    }
    """
    When I run Psalm
    Then I see no errors

  Scenario: Relationships can be accessed via a property
    Given I have the following code
    """
    function testGetPhone(User $user): Phone {
      return $user->phone;
    }

    function testGetUser(Phone $phone): User {
      return $phone->user;
    }
    """
    When I run Psalm
    Then I see no errors

  Scenario: Relationships can be filtered via dynamic property
    Given I have the following code
    """
    function testFilterRelationshipFromDynamicProperty(User $user): Phone {
      return $user->phone->where('active', 1)->firstOrFail();
    }
    """
    When I run Psalm
    Then I see no errors

  Scenario: Relationships can be further constrained via method
    Given I have the following code
    """
    function testFilterRelationshipFromMethod(User $user): Phone {
      return $user->phone()->where('active', 1)->firstOrFail();
    }
    """
    When I run Psalm
    Then I see no errors

  Scenario: Relationships return themselves when the underlying method returns a builder
    Given I have the following code
    """
    /**
    * @param HasOne<Phone> $relationship
    * @psalm-return HasOne<Phone>
    */
    function testRelationshipsReturnThemselvesInsteadOfBuilders(HasOne $relationship): HasOne {
      return $relationship->where('active', 1);
    }
    """
    When I run Psalm
    Then I see no errors
