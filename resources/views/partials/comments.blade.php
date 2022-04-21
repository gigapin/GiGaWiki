
<!-- COMMENTS -->
<div class="bg-white shadow-2xl rounded p-4 mt-8 border-t-2 border-green-600 md:w-8/12 md:mx-auto lg:py-6 2xl:py-8 2xl:mt-28">
    <div class="flex justify-between">
        <div>
            <button class="bg-green-400 text-xs lg:text-sm p-2 text-white rounded-md border-2 border-green-800" id="add-comment">Add Comment</button>
        </div>
        @if(count($comments) > 0)
            <div>
                <button class="bg-green-400 text-xs lg:text-sm p-2 text-white rounded-md border-2 border-green-800" id="show-comment">Show Comment</button>
            </div>
        @endif
    </div>

    <div id="form-comment" class="mt-6 w-11/12 mx-auto hidden">
        <form action="{{ route('comments.store', [$url, $slug->slug]) }}" method="POST">
            @csrf
            <textarea name="body" id="" class="w-full h-52 text-xs lg:text-sm border-gray-300"></textarea>
            <div class="grid justify-items-end">
                <input type="submit" class="bg-green-300 text-xs lg:text-sm p-2 text-gray-700 cursor-pointer mt-2" id="button-comment" value="Save Comment">
            </div>
        </form>
    </div>



    <div id="area-comment" class="hidden text-xs lg:text-sm">
        @foreach($comments as $comment)
            <div class="mt-6 bg-white border-2 border-gray-200 p-4 text-xs">
                <div class="flex justify-between">
                    <div class="w-1/2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill float-left mr-3" viewBox="0 0 16 16">
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                        </svg>
                        <div class="text-gray-600">
                            {{ $user->name }} commented  {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $comment->updated_at)->diffForHumans() }}
                        </div>
                    </div>

                    <div class="w-1/2">
                        <div class="flex items-stretch float-right">
                            <!-- EDIT -->
                            <div class="mr-2" >
                                <button id="edit-comment-button-{{ $comment->id }}" type="button" onclick="updateComment({{ $comment->id }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil text-gray-400 hover:text-gray-700" viewBox="0 0 16 16">
                                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                    </svg>
                                </button>
                            </div>

                            <!-- REPLY -->
                            <div class="mr-2">
                                <button id="reply-comment-button-{{ $comment->id }}" onclick="replyComment({{ $comment->id }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-reply text-gray-400 hover:text-gray-700" viewBox="0 0 16 16">
                                        <path d="M6.598 5.013a.144.144 0 0 1 .202.134V6.3a.5.5 0 0 0 .5.5c.667 0 2.013.005 3.3.822.984.624 1.99 1.76 2.595 3.876-1.02-.983-2.185-1.516-3.205-1.799a8.74 8.74 0 0 0-1.921-.306 7.404 7.404 0 0 0-.798.008h-.013l-.005.001h-.001L7.3 9.9l-.05-.498a.5.5 0 0 0-.45.498v1.153c0 .108-.11.176-.202.134L2.614 8.254a.503.503 0 0 0-.042-.028.147.147 0 0 1 0-.252.499.499 0 0 0 .042-.028l3.984-2.933zM7.8 10.386c.068 0 .143.003.223.006.434.02 1.034.086 1.7.271 1.326.368 2.896 1.202 3.94 3.08a.5.5 0 0 0 .933-.305c-.464-3.71-1.886-5.662-3.46-6.66-1.245-.79-2.527-.942-3.336-.971v-.66a1.144 1.144 0 0 0-1.767-.96l-3.994 2.94a1.147 1.147 0 0 0 0 1.946l3.994 2.94a1.144 1.144 0 0 0 1.767-.96v-.667z"/>
                                    </svg>
                                </button>
                            </div>

                            <!-- DELETE -->
                            <div>
                                <form action="{{ route('comments.destroy', [$url, $slug->slug, $comment->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-gray-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Edit Comment -->
                <div class="form-comment mx-auto hidden" id="edit-comment-{{ $comment->id }}">
                    <form action="{{ route('comments.update', [$url, $slug->slug, $comment->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <textarea name="body" id="" class="w-full h-50 border-gray-300 text-xs lg:text-sm">{{ $comment->body }}</textarea>
                        <div class="grid justify-items-end">
                            <input type="submit" class="bg-green-300 p-2 text-gray-700 cursor-pointer mt-2" id="button-comment" value="Update Comment">
                        </div>
                    </form>
                </div>

                <div class="mt-4" id="body-comment-{{ $comment->id }}">
                    {{ $comment->body }}
                </div>

                <!-- Reply Comments -->
                @foreach ($parents as $parent)
                    @if ($parent->parent_id === $comment->id)
                        <div class="mt-6 bg-white border-2 border-gray-200 p-4 text-xs">
                            <div class="">
                                <div class="w-1/2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill float-left mr-3" viewBox="0 0 16 16">
                                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                    </svg>
                                    <div class="text-gray-600">
                                        {{ $user->name }} commented  {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $parent->updated_at)->diffForHumans() }}
                                    </div>
                                </div>
                                <div class="mt-4" id="body-comment-{{ $parent->id }}">
                                    {{ $parent->body }}
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Reply Comment -->
            <div id="form-reply-comment-{{ $comment->id }}" class="mt-6 w-11/12 mx-auto hidden lg:ml-12">
                <p class="bg-green-200 text-sm p-1 text-gray-500">In reply to comment by {{ $user->name }}</p>
                <form action="{{ route('comments.reply', [$url, $slug->slug, $comment->id]) }}" method="POST">
                    @csrf
                    <textarea name="body" id="" class="w-full h-50 border-gray-300 text-xs lg:text-sm"></textarea>
                    <div class="grid justify-items-end">
                        <input type="submit" class="bg-green-300 p-2 text-gray-700 cursor-pointer mt-2 text-xs" id="button-comment" value="Save Comment">
                    </div>
                </form>
            </div>
        @endforeach
    </div>

</div>
