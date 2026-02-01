<?php

final class AcmeTest extends DatabaseTestCase
{

    public function testCreate(): void
    {
        $controller = $this->container->getByType(CreateAcmeController::class);

        // Prepare request
        $request = new ServerRequest(
            method: 'GET',
            url: 'test.tld',
            headers: [],
            body: stream_for(Json::encode([
                'epgFile' => '11111',
                'data' => ['foo' => 'bar'],
            ])),
            version: '1.1',
            serverParams: []
        );

        // Execute controller
        $response = $controller($request);

        // Asserts
        $this->assertInstanceOf(CreateAcmeResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());

        $this->assertStringMatchesFormat(Json::encode([
            'id' => '%s',
            'epgFile' => '11111',
            'data' => ['foo' => 'bar'],
            'hash' => null,
            'state' => 0,
            'statedAt' => '%s',
            'createdAt' => '%s',
            'updatedAt' => '%s',
        ]), Json::encode($response->getPayload()));
    }

}