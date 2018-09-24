<?php

namespace Mrgla55\Tabapi\Repositories;

use Mrgla55\Tabapi\Interfaces\RepositoryInterface;
use Mrgla55\Tabapi\Interfaces\EncryptorInterface;
use Mrgla55\Tabapi\Interfaces\StorageInterface;
use Mrgla55\Tabapi\Exceptions\MissingRefreshTokenException;

class RefreshTokenRepository implements RepositoryInterface {

    protected $encryptor;
    protected $storage;

    public function __construct(EncryptorInterface $encryptor, StorageInterface $storage) {
        $this->encryptor = $encryptor;
        $this->storage   = $storage;
    }

    /**
     * Encrypt refresh token and pass into session.
     *
     * @param array $token
     *
     * @return void
     */
    public function put($token)
    {
        $encryptedToken = $this->encryptor->encrypt($token);

        $this->storage->put('refresh_token', $encryptedToken);
    }

    public function has()
    {
        return $this->storage->has('refresh_token');
    }

    /**
     * Get refresh token from session and decrypt it.
     *
     * @return mixed
     */
    public function get()
    {
        $this->verifyRefreshTokenExists();

        $token = $this->storage->get('refresh_token');

        return $this->encryptor->decrypt($token);
    } 

    private function verifyRefreshTokenExists() {
        if ($this->storage->has('refresh_token')) return;

        throw new MissingRefreshTokenException(sprintf('No refresh token stored in current session. Verify you have added refresh_token to your scope items on your connected app settings in TAB.'));
    }
}