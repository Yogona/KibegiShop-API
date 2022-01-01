<!Doctype html>
<html>
    <head>
        <title>Email Verification</title>
    </head>
    <body>
        <h2>Email Verification</h2>
        <section>
            <p>
                
                This is Kibegi Shop front desk, thank you for taking your time creating an account with us.
                <br/>Before we can let you start using our application, we would like you to confirm your email address.
                <br/>This is important to ensure future account recovery, support and receive important updates information.
                <br/><br/><a href='{{ "http://localhost:8000/api/verify_email/$user/$token" }}' target='_blank'>Please click me to verify.</a>

                <br><em>Best Regards,
                    <br/>Kibegi Shop Team
                    </em>
            </p>
        </section>
    </body>
</html>