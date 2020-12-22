<?php

class BxExGValidatorTest extends AbstractTest {

    /**
     * @test
     */
    public function noErrors() {
        $source = '<bx ="23"/><g id="1">Ciao</g> questa è una stringa';
        $target = '<bx ="23"/><g id="1">Hi</g> this is a string';

        $qa        = new QA( $source, $target );
        $validator = new \BxExG\Validator( $qa );

        $this->assertEmpty( $validator->validate() );
    }

    /**
     * @test
     */
    public function nestedBxInTargetNotInSource() {
        $source = '<bx ="23"/><g id="1">Ciao</g> questa è una stringa';
        $target = '<g id="1"><bx ="23"/>Hi</g> this is a string';

        $qa        = new QA( $source, $target );
        $validator = new \BxExG\Validator( $qa );

        $this->assertCount( 1, $validator->validate() );
        $this->assertEquals( 1300, $validator->validate()[ 0 ] );
    }

    /**
     * @test
     */
    public function nestedBxInSourceNotInTarget() {
        $source = '<g id="1"><bx ="23"/>Ciao</g> questa è una stringa';
        $target = '<bx ="23"/><g id="1">Hi</g> this is a string';

        $qa        = new QA( $source, $target );
        $validator = new \BxExG\Validator( $qa );

        $this->assertCount( 1, $validator->validate() );
        $this->assertEquals( 1301, $validator->validate()[ 0 ] );
    }

    /**
     * @test
     */
    public function mismatchCountBetweenSourceAndTarget() {
        $source = '<g id="1"><bx ="23"/>Ciao</g> questa è una stringa<g id="2"></g>';
        $target = '<g id="1"><bx ="23"/>Hi</g> this is a string';

        $qa        = new QA( $source, $target );
        $validator = new \BxExG\Validator( $qa );

        $this->assertCount( 1, $validator->validate() );
        $this->assertEquals( 1302, $validator->validate()[ 0 ] );
    }

    /**
     * @test
     */
    public function nestedBxInTargetNotInSourceWithNestedStrings() {
        $source = '<bx ="23"/><g id="1"><g id="2"><g id="3">Ciao</g> questa è una stringa</g></g>';
        $target = '<g id="1"><g id="2"><g id="3"><bx ="23"/>Hi</g> this is a string</g></g>';

        $qa        = new QA( $source, $target );
        $validator = new \BxExG\Validator( $qa );

        $this->assertCount( 1, $validator->validate() );
        $this->assertEquals( 1300, $validator->validate()[ 0 ] );
    }

    /**
     * @test
     */
    public function noBxOrExTags() {
        $source = '<g id="1"><g id="2"><g id="3">Ciao</g> questa è una stringa</g></g><g id="5"></g>';
        $target = '<g id="1"><g id="2"><g id="3">Hi</g> this is a string</g></g><g id="4"></g>';

        $qa        = new QA( $source, $target );
        $validator = new \BxExG\Validator( $qa );

        $this->assertCount( 1, $validator->validate() );
        $this->assertEquals( 1301, $validator->validate()[ 0 ] );
    }
}