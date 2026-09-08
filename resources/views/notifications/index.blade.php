@extends('layouts.app')

@section('content')

<div class="page-header">

    <div class="page-title">

        <div class="page-title-icon">

            <i class="bi bi-bell-fill"></i>

        </div>

        <div>

            <h1>Notifications</h1>

            <p>

                View and manage all your system notifications.

            </p>

        </div>

    </div>


    @if(auth()->user()->unreadNotifications->count() > 0)

        <form
            action="{{ route('notifications.read-all') }}"
            method="POST"
        >

            @csrf

            <button
                type="submit"
                class="btn btn-primary"
            >

                <i class="bi bi-check2-all me-1"></i>

                Mark All as Read

            </button>

        </form>

    @endif

</div>


<div class="modern-page-card">

    <div class="card-body p-0">


        @if($notifications->count() > 0)

            <div class="notification-list">


                @foreach($notifications as $notification)

                    <div
                        class="notification-item
                        {{ is_null($notification->read_at) ? 'notification-unread' : '' }}"
                    >


                        <div class="notification-icon">

                            @php

                                $type =
                                    $notification->data['type']
                                    ?? 'default';

                            @endphp


                            @if($type === 'success')

                                <i class="bi bi-check-circle-fill text-success"></i>

                            @elseif($type === 'warning')

                                <i class="bi bi-exclamation-triangle-fill text-warning"></i>

                            @elseif($type === 'danger')

                                <i class="bi bi-x-circle-fill text-danger"></i>

                            @elseif($type === 'borrowed')

                                <i class="bi bi-book-fill text-primary"></i>

                            @elseif($type === 'returned')

                                <i class="bi bi-arrow-return-left text-success"></i>

                            @elseif($type === 'overdue')

                                <i class="bi bi-clock-history text-danger"></i>

                            @else

                                <i class="bi bi-bell-fill text-primary"></i>

                            @endif

                        </div>


                        <div class="notification-content">


                            <div class="notification-header">


                                <h6>

                                    {{
                                        $notification->data['title']
                                        ?? 'New Notification'
                                    }}

                                </h6>


                                @if(is_null($notification->read_at))

                                    <span
                                        class="badge-soft-primary notification-new-badge"
                                    >

                                        New

                                    </span>

                                @endif

                            </div>


                            <p>

                                {{
                                    $notification->data['message']
                                    ?? 'You have received a new notification.'
                                }}

                            </p>


                            <div class="notification-time">

                                <i class="bi bi-clock me-1"></i>

                                {{ $notification->created_at->diffForHumans() }}

                            </div>

                        </div>


                        <div class="notification-action">


                            @if(is_null($notification->read_at))

                                <form
                                    action="{{ route('notifications.read', $notification->id) }}"
                                    method="POST"
                                >

                                    @csrf

                                    <button
                                        type="submit"
                                        class="btn btn-sm btn-primary"
                                    >

                                        <i class="bi bi-check2 me-1"></i>

                                        Mark Read

                                    </button>

                                </form>

                            @else

                                @if(
                                    isset($notification->data['url'])
                                    &&
                                    $notification->data['url']
                                )

                                    <a
                                        href="{{ $notification->data['url'] }}"
                                        class="btn btn-sm btn-outline-primary"
                                    >

                                        <i class="bi bi-eye me-1"></i>

                                        View

                                    </a>

                                @else

                                    <span
                                        class="notification-read-text"
                                    >

                                        <i class="bi bi-check-circle-fill"></i>

                                        Read

                                    </span>

                                @endif

                            @endif

                        </div>

                    </div>

                @endforeach


            </div>


            <div class="notification-pagination">

                {{ $notifications->links() }}

            </div>


        @else


            <div class="empty-notifications">


                <div class="empty-notification-icon">

                    <i class="bi bi-bell-slash"></i>

                </div>


                <h4>

                    No Notifications

                </h4>


                <p>

                    You do not have any notifications at the moment.

                </p>

            </div>


        @endif


    </div>

</div>


<style>


    /*
    |--------------------------------------------------------------------------
    | Notifications
    |--------------------------------------------------------------------------
    */

    .notification-list {

        width: 100%;

    }


    .notification-item {

        display: flex;

        align-items: center;

        gap: 18px;

        padding: 20px 25px;

        border-bottom:
            1px solid
            var(--border);

        transition:
            all
            0.25s
            ease;

    }


    .notification-item:last-child {

        border-bottom: none;

    }


    .notification-item:hover {

        background:
            #F8FBFF;

    }


    /*
    |--------------------------------------------------------------------------
    | Unread Notification
    |--------------------------------------------------------------------------
    */

    .notification-unread {

        background:
            linear-gradient(
                90deg,
                #EFF6FF,
                #FFFFFF
            );

        border-left:
            4px solid
            var(--primary);

    }


    /*
    |--------------------------------------------------------------------------
    | Notification Icon
    |--------------------------------------------------------------------------
    */

    .notification-icon {

        width: 52px;

        height: 52px;

        min-width: 52px;

        display: flex;

        align-items: center;

        justify-content: center;

        border-radius: 14px;

        background:
            #F8FAFC;

        font-size: 24px;

    }


    /*
    |--------------------------------------------------------------------------
    | Notification Content
    |--------------------------------------------------------------------------
    */

    .notification-content {

        flex: 1;

        min-width: 0;

    }


    .notification-header {

        display: flex;

        align-items: center;

        gap: 10px;

        margin-bottom: 6px;

    }


    .notification-header h6 {

        margin: 0;

        font-size: 15px;

        font-weight: 700;

        color:
            var(--text-dark);

    }


    .notification-content p {

        margin: 0 0 8px;

        color:
            var(--text-muted);

        font-size: 14px;

        line-height: 1.6;

    }


    .notification-time {

        color:
            #94A3B8;

        font-size: 12px;

    }


    /*
    |--------------------------------------------------------------------------
    | New Badge
    |--------------------------------------------------------------------------
    */

    .notification-new-badge {

        font-size: 10px;

        font-weight: 700;

    }


    /*
    |--------------------------------------------------------------------------
    | Notification Actions
    |--------------------------------------------------------------------------
    */

    .notification-action {

        min-width: 120px;

        display: flex;

        justify-content: flex-end;

    }


    .notification-read-text {

        display: flex;

        align-items: center;

        gap: 6px;

        color:
            var(--success);

        font-size: 13px;

        font-weight: 600;

    }


    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    */

    .notification-pagination {

        padding: 20px 25px;

        border-top:
            1px solid
            var(--border);

    }


    /*
    |--------------------------------------------------------------------------
    | Empty Notifications
    |--------------------------------------------------------------------------
    */

    .empty-notifications {

        padding:
            80px
            20px;

        text-align: center;

    }


    .empty-notification-icon {

        width: 80px;

        height: 80px;

        margin:
            0 auto
            20px;

        display: flex;

        align-items: center;

        justify-content: center;

        border-radius: 50%;

        background:
            var(--primary-light);

        color:
            var(--primary);

        font-size: 35px;

    }


    .empty-notifications h4 {

        margin-bottom: 8px;

        font-weight: 700;

    }


    .empty-notifications p {

        margin: 0;

        color:
            var(--text-muted);

    }


    /*
    |--------------------------------------------------------------------------
    | Mobile
    |--------------------------------------------------------------------------
    */

    @media (max-width: 768px) {

        .notification-item {

            align-items: flex-start;

            flex-wrap: wrap;

            padding: 18px;

        }


        .notification-icon {

            width: 45px;

            height: 45px;

            min-width: 45px;

            font-size: 20px;

        }


        .notification-content {

            width:
                calc(
                    100% - 63px
                );

        }


        .notification-action {

            width: 100%;

            justify-content: flex-start;

            margin-left: 63px;

        }


        .notification-pagination {

            padding: 15px;

        }

    }


</style>

@endsection