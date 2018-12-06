<section>
    <form action="/distributors/applications" method="POST">
        {!! csrf_field() !!}
        <div>
            <label for="name">Name:</label>
            <input type="text" name="name" id="name">
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email">
        </div>
        <div>
            <label for="country">country:</label>
            <input type="text" name="country" id="country">
        </div>
        <div>
            <label for="company">company:</label>
            <input type="text" name="company" id="company">
        </div>
        <div>
            <label for="website">website:</label>
            <input type="text" name="website" id="website">
        </div>
        <div>
            <label for="application_message">Message:</label>
            <input type="text" name="application_message" id="application_message">
        </div>
        <div>
            <span>How did you hear about us?</span>
            <div>
                <div>
                    <label for="google">google</label>
                    <input type="radio" name="referrer" id="google" value="google">
                </div>
                <div>
                    <label for="exhibition">exhibition</label>
                    <input type="radio" name="referrer" id="exhibition" value="exhibition">
                </div>
                <div>
                    <label for="taiwan_trade">taiwan_trade</label>
                    <input type="radio" name="referrer" id="taiwan_trade" value="taiwan trade">
                </div>
                <div>
                    <label for="social_media">social_media</label>
                    <input type="radio" name="referrer" id="social_media" value="social media">
                </div>
                <div>
                    <label for="other">other</label>
                    <input type="radio" name="referrer" id="other" value="other">
                </div>
            </div>
        </div>
        <div>
            <button type="submit">Send application</button>
        </div>
    </form>
</section>