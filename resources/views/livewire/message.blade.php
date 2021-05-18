<div>
    <section style="padding-top:60px  " xmlns:wire="http://www.w3.org/1999/xhtml">
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="card-header">
                        Send Message
                    </div>
                    <div class="card">
                        <div class="card-body">
                            @if(Session::has('message_sent'))
                                <div class="alert alert-success" role="alert">
                                    {{Session::get('message_sent')}}
                                </div>
                            @endif
                            <form name="form-message" id="form-message" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="sender" id="sender" value="{{$currentUser}}"
                                       wire:model="sender">
                                <div wire:ignore.self class="form-group" wire:model="receivers">
                                    <label for="users">Send To : </label>
                                    <select id="users" class="mul-select" aria-label="Default select example" multiple>
                                        @foreach($users as $user)
                                            @if($user->id != $currentUser)
                                                <option value="{{$user->id}}">{{$user->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('receivers') <span class="text-danger">{{$message}}</span> @enderror

                                    <br>
                                </div>
                                <br>
                                <div wire:ignore.self class="form-group" wire:model.debounce.1000ms="title">
                                    <lable for="title">Message Title</lable>
                                    <input type="text" name="title" class="form-control"
                                           placeholder="Enter Message Title"/>
                                    @error('title') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <br>
                                <div wire:ignore.self class="form-group" wire:model.debounce.1000ms="body">
                                    <lable for="body">Message Content</lable>
                                    <textarea name="body" class="form-control" rows="3"></textarea>
                                    @error('body') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                                <div class="form-group">
                                    <label for="file">Select File</label>
                                    <input type="file" name="filesnames" class="form-control" multiple
                                           wire:model="filesnames">
                                </div>
                                <br>
                                <button type="submit" class="btn btn-success" wire:click.prevent="sendMessage()">Send
                                    Message
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>

<script>
    // $('.selectpicker').on('changed.bs.select', function () {
    //     var selected = $('option:selected');
    // });
</script>
