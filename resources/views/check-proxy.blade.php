<div>
    <form action="/check-proxy" method="post">
        @csrf
        <p><b>Proxy:</b></p>
        <p><label for="proxy"></label><textarea rows="10" cols="45" name="proxy" id="proxy"></textarea></p>
        <p><input type="submit" value="Send"></p>
    </form>

</div>
