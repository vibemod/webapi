<?php

final class AcmeTest extends DatabaseTestCase
{

    public function setUp(): void
    {
        parent::setUp();

        // Populate data
        $acmeSource = new AcmeSource(id: '11111', url: 'test.tld');
        $this->em->persist($acmeSource);

        $acmeFile = new AcmeFile(id: '11111', epgSource: $acmeSource, content: 'test content 1');
        $this->em->persist($acmeFile);

        $this->em->flush();
    }

}