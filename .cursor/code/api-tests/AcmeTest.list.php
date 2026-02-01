<?php

final class AcmeTest extends DatabaseTestCase
{

    public function testList(): void
    {
        $controller = $this->container->getByType(ListAcmesController::class);

        // Prepare request
        $request = new ServerRequest(
            method: 'GET',
            url: 'test.tld',
            headers: [],
            body: '',
            version: '1.1',
            serverParams: []
        );

        // Execute controller
        $response = $controller($request);

        // Asserts
        $this->assertInstanceOf(ListAcmesResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertCount(1, $response->getEntities());
    }
}
