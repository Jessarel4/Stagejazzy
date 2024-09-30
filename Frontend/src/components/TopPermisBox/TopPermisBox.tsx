import  { useState, useEffect } from 'react';
import axios from 'axios';

const TopPermisBox = ({ periode }: { periode: string }) => {
    const [topPermis, setTopPermis] = useState<any[]>([]);

    useEffect(() => {
        const fetchTopPermis = async () => {
            try {
                const response = await axios.get(`http://127.0.0.1:8000/api/top-permis`, {
                    params: { periode }
                });
                setTopPermis(response.data);
            } catch (error) {
                console.error("Erreur lors du chargement des meilleurs permis :", error);
            }
        };

        fetchTopPermis();
    }, [periode]);

    return (
        <div className="topPermisBox">
            <h3>Top 5 des Permis avec les meilleures Ristournes et Redevances</h3>
            <ul>
                {topPermis.map((permis, index) => (
                    <li key={index}>
                        <strong>{permis.titre_permis_e}</strong> 
                        <p>Redevance: {permis.redevance} - Ristourne: {permis.ristourne}</p>
                    </li>
                ))}
            </ul>
        </div>
    );
};

export default TopPermisBox;
