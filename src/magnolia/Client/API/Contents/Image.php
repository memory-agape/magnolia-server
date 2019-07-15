<?php
namespace Magnolia\Client\API\Contents;

use Magnolia\Contract\APIContentsInterface;
use Magnolia\Exception\FileNotFoundException;
use Magnolia\Traits\APIResponseable;
use Magnolia\Traits\CookieUsable;
use Magnolia\Traits\SessionUsable;
use Magnolia\Utility\Storage;

final class Image extends AbstractAPIContents implements APIContentsInterface
{
    public function getResponseBody(): array
    {
        if (!$this->getSession()->has('user')) {
            return $this->returnUnauthorized(
                'You did not logged-in.'
            );
        }
        $id = str_replace('/', '', $this->getQuery()->get('id'));
        $date = str_replace('/', '', $this->getQuery()->get('date'));

        $user = $this->getSession()->read('user');
        $userId = $user['id'];
        $file = "/{$userId}/{$date}.jpg";

        if (
            $id !== $userId ||
            !is_file(Storage::getPath($file))
        ) {
            return $this->returnNotFound(
                'Image not found.'
            );
        }

        $this->setContentType('jpg');

        return [
            'body' => fopen(Storage::getPath($file), 'r'),
        ];
    }
}