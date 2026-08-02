import { Form, Head } from '@inertiajs/react';
import InputError from '@/components/input-error';
import PasswordInput from '@/components/password-input';
import TextLink from '@/components/text-link';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { store } from '@/routes/login';
import { request } from '@/routes/password';

type Props = {
    status?: string;
    canResetPassword: boolean;
};

export default function Login({ status, canResetPassword }: Props) {
    return (
        <>
            <Head title="Login" />

            <Form
                {...store.form()}
                resetOnSuccess={['password']}
            >
                {({ processing, errors }) => (
                    <>
                        <div className="card mb-0 shadow-none rounded-0 vh-100 h-100">
                            <div className="auth-max-width mx-auto d-flex align-items-center w-100 h-100">
                                <div className="card-body">
                                    <div className="mb-5">
                                        <h2 className="fw-bolder fs-7 mb-3">Welcome back</h2>
                                        <p className="mb-0 ">
                                            Enter your credentials to access the admin.
                                        </p>
                                    </div>
                                    <div className="mb-3">
                                        <Label htmlFor="username" className="form-label">Username</Label>
                                        <Input
                                            id="username"
                                            type="username"
                                            name="username"
                                            className="form-control"
                                            required
                                            autoFocus
                                            tabIndex={1}
                                            autoComplete="username"
                                            aria-describedby="username"
                                            placeholder="Enter Username"
                                        />
                                        <InputError message={errors.username} />
                                    </div>
                                    <div className="mb-3">
                                        <Label htmlFor="password" className="form-label">Password</Label>
                                        <PasswordInput
                                            id="password"
                                            name="password"
                                            className="form-control"
                                            required
                                            tabIndex={2}
                                            aria-describedby="password"
                                            placeholder="Enter Password"
                                        />
                                        <InputError message={errors.password} />
                                    </div>

                                    <div className="flex items-center space-x-3">
                                        <Checkbox
                                            id="remember"
                                            name="remember"
                                            tabIndex={3}
                                        />
                                        <Label htmlFor="remember" className="form-label">Remember me</Label>
                                    </div>

                                    <Button
                                        type="submit"
                                        className="mt-4 w-100"
                                        tabIndex={4}
                                        disabled={processing}
                                        data-test="login-button"
                                        variant="default"
                                    >
                                        {processing && <Spinner className="me-2 display-inline" />}
                                        Login
                                    </Button>
                                </div>
                            </div>
                        </div>
                    </>
                )}
            </Form>
            {status && (
                <div className="mb-4 text-center text-sm font-medium text-green-600">
                    {status}
                </div>
            )}
        </>
    );
}

Login.layout = {
    title: 'Log in to your account',
    description: 'Enter your username and password below to log in',
};
