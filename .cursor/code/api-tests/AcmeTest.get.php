<?php

final class AcmeTest extends DatabaseTestCase
{

    public function testGet(): void
    {
        $controller = $this->container->getByType(GetAcmeController::class);

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
        $this->assertInstanceOf(GetAcmeResponse::class, $response);
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
