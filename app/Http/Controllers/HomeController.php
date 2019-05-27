<?php

namespace App\Http\Controllers;

use App\Http\Repositories\OrderRepository;
use App\Http\Repositories\UserRepository;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(OrderRepository $orderRepository, UserRepository $userRepository)
    {
        $orderRepository->byName("test")->get();

        dd(
            $orderRepository->byName("test"),
            $userRepository->byName('jefferson')->where('email', 'test')
        );

        return view('home');
    }
}
