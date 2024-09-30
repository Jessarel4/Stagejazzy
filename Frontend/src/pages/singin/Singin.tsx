import React, { useState } from 'react';
import './Singin.scss';
import { Link, useNavigate } from 'react-router-dom';
import axios from 'axios';
import video from '../../LoginAssets/video.mp4';
import logo from '../../LoginAssets/logoMMRS.png';
import { FaUserShield } from 'react-icons/fa';
import { BsFillShieldLockFill } from 'react-icons/bs';
import { AiOutlineSwapRight } from 'react-icons/ai';

const Login = () => {
    const [loginUsername, setLoginUsername] = useState('');
    const [loginPassword, setLoginPassword] = useState('');
    const navigate = useNavigate();

    const loginUser = async (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();
        try {
            const response = await axios.post('http://127.0.0.1:8000/api/login', {
                username: loginUsername,
                password: loginPassword,
            });
    
            console.log('Réponse du serveur:', response.data);
            if (response.data.success) {
                localStorage.setItem('token', response.data.token);
                navigate('http://localhost:5173/');
            } else {
                console.error(response.data.message);
            }
        } catch (error) {
            console.error('Erreur de connexion:', error);
        }
    };
    

    return (
        <div className='loginPage flex'>
            <div className='logincontainer flex'>
                <div className='videoDiv'>
                    <video src={video} autoPlay muted loop></video>
                    <div className="textDiv">
                        <h2 className='title'>Notre équipe est notre Force</h2>
                        <p>Ministeres des mines et des strategies</p>
                    </div>
                    <div className="footerDiv flex">
                        <span className="text">Vous avez deja un compte?</span>
                        <Link to={'/register'}>
                            <button className='btn bt'>connexion</button>
                        </Link>
                    </div>
                </div>
                <div className="formDiv flex">
                    <div className="headerDiv">
                        <img src={logo} alt="Logo Image" />
                        <h3>
                            Remplissez les informations
                        </h3>
                    </div>
                    <form className='form grid' onSubmit={loginUser}>
                        <div className="inputDiv">
                            <label htmlFor="username">Prénom</label>
                            <div className="input flex">
                                <FaUserShield className='icon' />
                                <input type="text" id='username' placeholder='Entrer username'
                                    onChange={(event) => setLoginUsername(event.target.value)} />
                            </div>
                        </div>
                        <div className="inputDiv">
                            <label htmlFor="email">email</label>
                            <div className="input flex">
                                <FaUserShield className='icon' />
                                <input type="text" id='email' placeholder='Entrer email'
                                    onChange={(event) => setLoginUsername(event.target.value)} />
                            </div>
                        </div>
                        <div className="inputDiv">
                            <label htmlFor="password">Mot de passe</label>
                            <div className="input flex">
                                <BsFillShieldLockFill className='icon' />
                                <input type="password" id='password' placeholder='Entrer mot de passe'
                                    onChange={(event) => setLoginPassword(event.target.value)} />
                            </div>
                        </div>
                        <button type='submit' className='btn flex'>
                            <span>Inscription</span>
                            <AiOutlineSwapRight className='icon' />
                        </button>
                        <br />
                        {/* <span className='forgotPassword'>
                            Mot de passe oublié <a href="">Cliquez ici</a>
                        </span> */}
                    </form>
                </div>
            </div>
        </div>
    );
};

export default Login;
