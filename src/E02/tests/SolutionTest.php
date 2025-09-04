<?php

namespace App\Tests;

use App\Models\User;
use App\Models\Course;
use App\Models\Topic;
use App\Models\Course\CourseMember;
use App\Models\Course\CourseReview;
use App\Tests\BaseTest;

class SolutionTest extends BaseTest
{
    public function testUserHasManyTopics(): void
    {
        $user = User::factory()->create();
        $topic1 = Topic::factory()->create(['user_id' => $user->id]);
        $topic2 = Topic::factory()->create(['user_id' => $user->id]);

        $this->assertEquals(2, $user->topics()->count());
        $this->assertTrue($user->topics->contains($topic1));
        $this->assertTrue($user->topics->contains($topic2));
    }

    public function testUserHasManyCourseMembers(): void
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();
        $courseMember1 = CourseMember::factory()->create(['user_id' => $user->id, 'course_id' => $course->id]);
        $courseMember2 = CourseMember::factory()->create(['user_id' => $user->id, 'course_id' => $course->id]);

        $this->assertEquals(2, $user->courseMembers()->count());
        $this->assertTrue($user->courseMembers->contains($courseMember1));
        $this->assertTrue($user->courseMembers->contains($courseMember2));
    }

    public function testUserHasManyCourseReviews(): void
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();
        $courseMember = CourseMember::factory()->create(['user_id' => $user->id, 'course_id' => $course->id]);

        $review1 = CourseReview::factory()
            ->create(['user_id' => $user->id, 'course_member_id' => $courseMember->id, 'course_id' => $course->id]);
        $review2 = CourseReview::factory()
            ->create(['user_id' => $user->id, 'course_member_id' => $courseMember->id, 'course_id' => $course->id]);

        $this->assertEquals(2, $user->courseReviews()->count());
        $this->assertTrue($user->courseReviews->contains($review1));
        $this->assertTrue($user->courseReviews->contains($review2));
    }

    public function testTopicBelongsToUser(): void
    {
        $user = User::factory()->create();
        $topic = Topic::factory()->create(['user_id' => $user->id]);

        $this->assertTrue($user->is($topic->user()->first()));
    }

    public function testCourseHasManyCourseMembers(): void
    {
        $course = Course::factory()->create();
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $courseMember1 = CourseMember::factory()->create(['course_id' => $course->id, 'user_id' => $user1->id]);
        $courseMember2 = CourseMember::factory()->create(['course_id' => $course->id, 'user_id' => $user2->id]);

        $this->assertEquals(2, $course->members()->count());
        $this->assertTrue($course->members->contains($courseMember1));
        $this->assertTrue($course->members->contains($courseMember2));
    }

    public function testCourseHasManyCourseReviews(): void
    {
        $course = Course::factory()->create();
        $user = User::factory()->create();
        $courseMember = CourseMember::factory()->create(['course_id' => $course->id, 'user_id' => $user->id]);
        $review1 = CourseReview::factory()
            ->create(['course_id' => $course->id, 'course_member_id' => $courseMember->id, 'user_id' => $user->id]);
        $review2 = CourseReview::factory()
            ->create(['course_id' => $course->id, 'course_member_id' => $courseMember->id, 'user_id' => $user->id]);

        $this->assertEquals(2, $course->reviews()->count());
        $this->assertTrue($course->reviews->contains($review2));
    }

    public function testCourseMemberBelongsToUser(): void
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();
        $courseMember = CourseMember::factory()->create(['user_id' => $user->id, 'course_id' => $course->id]);

        $this->assertTrue($user->is($courseMember->user()->first()));
    }

    public function testCourseMemberBelongsToCourse(): void
    {
        $course = Course::factory()->create();
        $user = User::factory()->create();
        $courseMember = CourseMember::factory()->create(['user_id' => $user->id, 'course_id' => $course->id]);

        $this->assertTrue($course->is($courseMember->course->first()));
    }

    public function testCourseReviewBelongsToMember(): void
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();
        $courseMember = CourseMember::factory()->create(['user_id' => $user->id, 'course_id' => $course->id]);
        $review = CourseReview::factory()
            ->create(['course_member_id' => $courseMember->id, 'course_id' => $course->id, 'user_id' => $user->id]);

        $this->assertTrue($review->member()->exists());
        $this->assertTrue($courseMember->is($review->member()->first()));
    }

    public function testCourseReviewBelongsToCourse(): void
    {
        $course = Course::factory()->create();
        $user = User::factory()->create();
        $courseMember = CourseMember::factory()->create(['user_id' => $user->id, 'course_id' => $course->id]);
        $review = CourseReview::factory()
            ->create(['course_member_id' => $courseMember->id, 'course_id' => $course->id, 'user_id' => $user->id]);

        $this->assertTrue($course->is($review->course()->first()));
    }

    public function testCourseReviewBelongsToUser(): void
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();
        $courseMember = CourseMember::factory()
            ->create(['user_id' => $user->id, 'course_id' => $course->id]);
        $review = CourseReview::factory()
            ->create(['course_member_id' => $courseMember->id, 'course_id' => $course->id, 'user_id' => $user->id]);

        $this->assertTrue($user->is($review->user()->first()));
    }
}
