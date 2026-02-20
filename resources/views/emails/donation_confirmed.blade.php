<h2>Merci pour votre don 🙏</h2>

<p>
Vous avez fait un don de 
<strong>{{ number_format($don->montant, 0, ',', ' ') }} XOF</strong>
pour la cagnotte :
<strong>{{ $don->cagnotte->title }}</strong>
</p>

<p>
Date : {{ $don->created_at->format('d/m/Y H:i') }}
</p>

<p>
Merci pour votre générosité ❤️
</p>