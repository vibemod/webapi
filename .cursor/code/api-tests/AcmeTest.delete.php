<?php

final class AcmeTest extends DatabaseTestCase
{

    public function testDelete(): void
    {
        $controller = $this->container->getByType(DeleteAcmeController::class);

        // Prepare request
        $request = new ServerRequest(
            method: 'GET',
            url: 'test.tld',
            headers: [],
            body: '',
            version: '1.1',
            serverParams: []
        );
        $request = $request->withAttribute('id', '11111');

        // Execute controller
        $response = $controller($request);

        // Asserts
        $this->assertInstanceOf(DeleteAcmeResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(null, $response->getPayload());
    }

}