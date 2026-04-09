<x-layout>

	<x-forms.form title="Log in" description="Hello again">

		<form action="/login" method="POST" class="mt-10 space-y-4">
			@csrf

            <x-forms.field name="email" label="Email" type="email" />
            <x-forms.field name="password" label="Password" type="password" />

			<button type="submit" class="btn btn-2 h-10 w-full" data-test="login-button">Sign in</button>

		</form>

	</x-forms.form>

</x-layout>
