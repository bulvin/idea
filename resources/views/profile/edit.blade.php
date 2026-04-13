<x-layout>

	<x-forms.form title="Edit your account" description="Need to make a tweak?">

		<form action="/profile" method="POST" class="mt-10 space-y-4">
			@csrf
            @method('PATCH')

            <x-forms.field name="name" label="Name" :value="$user->name" />
            <x-forms.field name="email" label="Email" type="email" :value="$user->email" />
            <x-forms.field name="password" label="New Password" type="password" />

			<button type="submit" class="btn btn-2 h-10 w-full">Update Account</button>

		</form>

	</x-forms.form>

</x-layout>

