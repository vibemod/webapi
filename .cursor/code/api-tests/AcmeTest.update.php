<?php

final class AcmeTest extends DatabaseTestCase
{

    public function testUpdate(): void
    {
        $controller = $this->container->getByType(UpdateAcmeController::class);

        // Prepare request
        $request = new ServerRequest(
            method: 'GET',
            url: 'test.tld',
            headers: [],
            body: stream_for(Json::encode([
                'epgFile' => '22222',
                'data' => ['foo2' => 'bar2'],
            ])),
            version: '1.1',
            serverParams: []
        );
        $request = $request->withAttribute('id', '11111');

        // Execute controller
        $response = $controller($request);

        // Asserts
        $this->assertInstanceOf(UpdateAcmeResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());

        $this->assertStringMatchesFormat(Json::encode([
            'id' => '%s',
            'epgFile' => '22222',
            'data' => ['foo2' => 'bar2'],
            'hash' => null,
            'state' => 0,
            'statedAt' => '%s',
            'createdAt' => '%s',
            'updatedAt' => '%s',
        ]), Json::encode($response->getPayload()));
    }
}