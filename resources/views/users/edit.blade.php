<x-app-layout>

    <div class="container">

        <form action="{{ route('accounts.update', $account->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">City</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" name="city" value="{{ is_null($account->city) ? '' : $account->city }}">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Country</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" name="country" value="{{ is_null($account->country) ? '' : $account->country }}">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Language</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" name="language" value="{{ is_null($account->language) ? '' : $account->language }}">
            </div>
            @if($account->visibility === 'private')
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="private" id="flexCheckDefault" name="visibility" checked>
                    <label class="form-check-label" for="flexCheckDefault">
                        Private
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="public" id="flexCheckChecked" name="visibility">
                    <label class="form-check-label" for="flexCheckChecked">
                        Public
                    </label>
                </div>
            @else
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="private" id="flexCheckDefault" name="visibility">
                    <label class="form-check-label" for="flexCheckDefault">
                        Private
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="public" id="flexCheckChecked" name="visibility" checked>
                    <label class="form-check-label" for="flexCheckChecked">
                        Public
                    </label>
                </div>
            @endif
            @if(! is_null($account->avatar))
                <img src="{{ asset('storage/' . $account->avatar) }}" alt="" class="img-thumbnail" width="200" height="200">
            @endif
            <div class="input-group">
                <input type="file" class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload" name="avatar">
                <button class="btn btn-outline-secondary" type="button" id="inputGroupFileAddon04">Button</button>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>

    </div>


</x-app-layout>
