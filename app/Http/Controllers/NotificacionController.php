<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificacionController extends Controller
{
    public function index()
    {
        $notificaciones = auth::user()->notifications()->paginate(20);
        
        return view('notificaciones.index', compact('notificaciones'));
    }

    public function marcarComoLeida($id)
    {
        $notificacion = auth::user()->notifications()->findOrFail($id);
        $notificacion->markAsRead();
        
        return back()->with('success', 'Notificación marcada como leída');
    }

    public function marcarTodasLeidas()
    {
        auth::user()->unreadNotifications->markAsRead();
        
        return back()->with('success', 'Todas las notificaciones fueron marcadas como leídas');
    }
}