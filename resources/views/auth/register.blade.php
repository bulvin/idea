<x-layout>

	<x-forms.form title="Register an account" description="Start tracking your ideas.">

		<form action="/register" method="POST" class="mt-10 space-y-4">
			@csrf

            <x-forms.field name="name" label="Name" />
            <x-forms.field name="email" label="Email" type="email" />
            <x-forms.field name="password" label="Password" type="password" />

			<button type="submit" class="btn btn-2 h-10 w-full">Create Account</button>

		</form>

	</x-forms.form>

</x-layout>
