<?php

use App\Exceptions\BaseException;
use App\Exceptions\NotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        
        // Render method with explicit return and no fallback
        $exceptions->render(function (Throwable $e, Request $request) {
            // Debug: Always log what exception we're catching
            //\Log::info('Exception caught: ' . get_class($e) . ' - ' . $e->getMessage());
            
            // Handle ModelNotFoundException
            if ($e instanceof ModelNotFoundException || $e instanceof NotFoundHttpException) {
                
                $isModelException = $e instanceof ModelNotFoundException || 
                $e instanceof NotFoundHttpException && $e->getPrevious() instanceof ModelNotFoundException ; 

                throw new BaseException(
                message: $isModelException ? 'Resource not found' : 'Page Not Found' , 
                //view: 'Application.errors.notFound' , 
                statusCode:404
                );
                
            }
 
            // Handle other HTTP exceptions
            if ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpException) {
                $statusCode = $e->getStatusCode();
                return response()->view('errors.http-error', [
                    'statusCode' => $statusCode,
                    'message' => $e->getMessage() ?: 'An error occurred',
                    'exception' => $e
                ], $statusCode);
            }
            
            // Handle general exceptions (500 errors)
            if (!app()->hasDebugModeEnabled()) {
                return response()->view('errors.server-error', [
                    'message' => 'Internal server error',
                    'exception' => $e
                ], 500);
            }
            
            // In debug mode, let Laravel handle it
            return null;
        });
    })
    ->create();