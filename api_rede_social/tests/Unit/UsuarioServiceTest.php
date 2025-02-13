<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Mockery;
use App\Services\UsuarioService;
use App\Repositories\Interfaces\UsuarioRepositoryInterface;

class UsuarioServiceTest extends TestCase
{
    protected $usuarioService;
    protected $usuarioRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock do UsuarioRepositoryInterface
        $this->usuarioRepositoryMock = Mockery::mock(UsuarioRepositoryInterface::class);
        $this->usuarioService = new UsuarioService($this->usuarioRepositoryMock);
    }

    public function testGetAllUsuarios()
    {
        $usuarios = [
            ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com'],
            ['id' => 2, 'name' => 'Jane Doe', 'email' => 'jane@example.com']
        ];

        $this->usuarioRepositoryMock
            ->shouldReceive('getAllUsuarios')
            ->once()
            ->andReturn($usuarios);

        $result = $this->usuarioService->getAllUsuarios();
        $this->assertEquals($usuarios, $result);
    }

    public function testCreateUsuario()
    {
        $usuarioData = ['name' => 'John Doe', 'email' => 'john@example.com', 'password' => 'secret'];
        $createdUsuario = ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com'];

        $this->usuarioRepositoryMock
            ->shouldReceive('createUsuario')
            ->once()
            ->with($usuarioData)
            ->andReturn($createdUsuario);

        $result = $this->usuarioService->createUsuario($usuarioData);
        $this->assertEquals($createdUsuario, $result);
    }

    public function testDeleteUsuario()
    {
        $usuarioId = 1;

        $this->usuarioRepositoryMock
            ->shouldReceive('deleteUsuario')
            ->once()
            ->with($usuarioId)
            ->andReturn(true);

        $result = $this->usuarioService->deleteUsuario($usuarioId);
        $this->assertTrue($result);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
