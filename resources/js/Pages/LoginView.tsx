import {FormEvent, useState} from 'react';
import LoginButtonSpinner from '../Components/Icons/LoginButtonSpinner';
import {dropAnimation} from '../Services/animation-config';
import ComponentsContainer from '../Components/Containers/ComponentsContainer';
import {motion} from 'framer-motion';
import {router} from '@inertiajs/react';

const LoginView = () => {
    const [email, setEmail] = useState<string>('');
    const [password, setPassword] = useState<string>('');
    const [isLoading, setIsLoading] = useState<boolean>(false);
    const [error, setError] = useState<string>('');

    const onEmailChange = (value: string): void => {
        setError('');
        setEmail(value);
        setIsLoading(false);
    };

    const onPasswordChange = (value: string): void => {
        setError('');
        setPassword(value);
        setIsLoading(false);
    };

    const handleSubmit = async (e: FormEvent) => {
        e.preventDefault();
        router.post('/login',
            {
                email: email,
                password: password,
            },
            {
                showProgress: false,
                onStart: () => setIsLoading(true),
                onFinish: () => setIsLoading(false),
                onError: (error) => {
                    console.log(error);
                    setError(error.message);
                },
            },
        );
    };

    return (
        <div className="flex flex-col items-center justify-center min-h-screen bg-black-900 p-4">
            <motion.div layout{...dropAnimation} className="w-full max-w-md">
                <ComponentsContainer>
                    <div className="w-full p-6">
                        <div className="text-center mb-8">
                            <h1 className="text-3xl font-semibold text-black-50">Prijava</h1>
                            <p className="text-black-300 mt-2">Vnesite svoje podatke za vpis v EnviPulse</p>
                        </div>

                        <form onSubmit={handleSubmit} className="space-y-6">
                            <div>
                                <label htmlFor="email" className="block text-sm font-medium text-black-50 mb-2">E-mail:</label>
                                <input
                                    id="email"
                                    name="email"
                                    type="email"
                                    autoComplete="email"
                                    required
                                    className="text-black-50 appearance-none block w-full px-3 py-2 border border-black-300 rounded-md shadow-sm placeholder-black-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="yourname@example.com"
                                    value={email}
                                    onChange={(e) => onEmailChange(e.target.value)}
                                />
                            </div>

                            <div>
                                <label htmlFor="password" className="block text-sm font-medium text-black-50 mb-2">Geslo:</label>
                                <input
                                    id="password"
                                    name="password"
                                    type="password"
                                    autoComplete="current-password"
                                    required
                                    className="text-black-50 appearance-none block w-full px-3 py-2 border border-black-300 rounded-md shadow-sm placeholder-black-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="••••••••"
                                    value={password}
                                    onChange={(e) => onPasswordChange(e.target.value)}
                                />
                            </div>

                            <div className="pt-4">
                                <button
                                    type="submit"
                                    disabled={isLoading}
                                    className="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-md font-medium text-blue-50 bg-blue-500 hover:bg-blue-700 hover:cursor-pointer disabled:cursor-not-allowed"
                                >
                                    {isLoading ? <LoginButtonSpinner /> : 'Vpis'}
                                </button>
                            </div>
                        </form>
                    </div>
                </ComponentsContainer>

                {error && (
                    <div className="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 text-center" role="alert">
                        <span className="block sm:inline">{error}</span>
                    </div>
                )}

            </motion.div>
        </div>
    );
}

export default LoginView;