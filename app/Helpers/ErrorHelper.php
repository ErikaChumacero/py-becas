<?php

namespace App\Helpers;

class ErrorHelper
{
    /**
     * Limpia y formatea mensajes de error de SQL Server para mostrarlos de forma amigable
     * 
     * @param string $errorMessage Mensaje de error completo
     * @return string Mensaje de error limpio y amigable
     */
    public static function cleanSqlError(string $errorMessage): string
    {
        // Extraer solo el mensaje después de "[SQL Server]"
        if (preg_match('/\[SQL Server\](.+?)(?:\(Connection:|$)/s', $errorMessage, $matches)) {
            $errorMessage = trim($matches[1]);
        }
        
        // Mensajes personalizados más amigables
        $friendlyMessages = [
            'ya tiene una postulación' => 'Ya existe una postulación registrada para esta convocatoria.',
            'ya existe un documento' => 'Ya has subido un documento para este requisito.',
            'convocatoria no está activa' => 'La convocatoria seleccionada no está activa.',
            'fuera del plazo' => 'La convocatoria está fuera del plazo de postulación.',
            'no se encontró' => 'El registro solicitado no existe.',
            'no existe' => 'El registro solicitado no existe.',
            'fechafin debe ser mayor' => 'La fecha de fin debe ser posterior a la fecha de inicio.',
            'fecha de fin debe ser mayor' => 'La fecha de fin debe ser posterior a la fecha de inicio.',
            'no se puede modificar una postulación finalizada' => 'No se puede modificar una postulación finalizada.',
            'postulación finalizada' => 'Esta postulación ya está finalizada y no puede modificarse.',
            'requisitos obligatorios' => 'Faltan documentos obligatorios por subir.',
            'no cumple con los requisitos' => 'No se cumplen todos los requisitos obligatorios.',
            'Error al' => 'Ocurrió un error al procesar la solicitud.',
        ];
        
        // Buscar y reemplazar con mensaje amigable
        foreach ($friendlyMessages as $pattern => $friendly) {
            if (stripos($errorMessage, $pattern) !== false) {
                return $friendly;
            }
        }
        
        // Si no hay coincidencia, limpiar el mensaje original
        // Eliminar información técnica innecesaria
        $errorMessage = preg_replace('/\(Connection:.*?\)/', '', $errorMessage);
        $errorMessage = preg_replace('/SQLSTATE\[.*?\]:?\s*/', '', $errorMessage);
        $errorMessage = preg_replace('/\[Microsoft\]\[ODBC Driver.*?\]\s*/', '', $errorMessage);
        $errorMessage = trim($errorMessage);
        
        return $errorMessage ?: 'Ocurrió un error al procesar la solicitud.';
    }
}
