import React, { useState, useEffect } from 'react';

const ChartBoxContainer3: React.FC = () => {
    const [currentDate, setCurrentDate] = useState<string>('');
    const [currentTime, setCurrentTime] = useState<string>('');

    useEffect(() => {
        const updateDateTime = () => {
            const now = new Date();
            const formattedDate = now.toLocaleDateString('fr-FR', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });
            const formattedTime = now.toLocaleTimeString('fr-FR', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            setCurrentDate(formattedDate);
            setCurrentTime(formattedTime);
        };

        // Update the date and time every second
        updateDateTime();
        const intervalId = setInterval(updateDateTime, 1000);

        // Clear the interval on component unmount
        return () => clearInterval(intervalId);
    }, []);

    return (
        <div style={{ textAlign: 'center', marginTop: '20px' }}>
    <div>
                <img src="/calendar.svg" alt="calendar icon" style={{ width: '30px', marginRight: '10px' }} />
                
            </div>
            <h1 style={{ display: 'inline-block' }}>{currentDate}</h1>
            <h2>{currentTime}</h2>
        </div>
    );
};

export default ChartBoxContainer3;
