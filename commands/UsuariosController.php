<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\Usuarios;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class UsuariosController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionDesbanear()
    {
        $usuarios = Usuarios::find()->where('banned_at IS NOT NULL');
        $contador = 0;
        foreach ($usuarios->each() as $usuario) {
            if ($usuario->desbaneable()) {
                if ($usuario->desbanear()) {
                    $contador++;
                }
            }
        }
        echo "Se han desbaneado $contador usuarios\n";
        return ExitCode::OK;
    }

    public function actionIndex($message = 'hello world')
    {
        echo $message . "\n";

        return ExitCode::OK;
    }
}
