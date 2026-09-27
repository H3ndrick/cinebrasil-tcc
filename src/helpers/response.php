<?php
    function jsonResponse(bool $success, string $mensagem = '', array $extra = []): void {
        header('Content-Type: application/json');
        echo json_encode(array_merge(['success' => $success, 'mensagem' => $mensagem], $extra));
        exit;
    }