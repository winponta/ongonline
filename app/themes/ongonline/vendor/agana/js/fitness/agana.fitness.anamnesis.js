Agana.Fitness = function() {
};

Agana.Fitness.Anamnesis = function() {
    var _weight = 0;
    var _age = 0;
    var _gender = '';

    var _vo2max_evaluation = 0;
    var _heart_rate_rest = 0;

    var _vo2_rest = 3.5;

    var _intensity_work_percentage = 0;

    this.getVO2Rest = function() {
        return _vo2_rest;
    }

    this.setWeight = function(w) {
        _weight = Agana.Math.parseFloat(w);
    };

    this.getWeight = function() {
        return _weight;
    };

    this.setAge = function(a) {
        _age = parseInt(a);
    };

    this.getAge = function() {
        return _age;
    };
    
    this.setHeartRateRest = function(h) {
        _heart_rate_rest = parseInt(h);
    };

    this.getHeartRateRest = function() {
        return _heart_rate_rest;
    };

    this.setGender = function(g) {
        _gender = g;
    };

    this.getGender = function() {
        return _gender;
    };

    this.setIntensityWorkPercentage = function(iwp) {
        _intensity_work_percentage = Agana.Math.parseFloat(iwp) / 100;
    };

    this.getIntensityWorkPercentage = function() {
        return _intensity_work_percentage * 100;
    }

    validateGender = function() {
        if (_gender != 'M' && _gender != 'F') {
            throw "gender is not valid, only M or F are allowed";
        }
    };

    this.setVO2maxEvaluation = function(vo2e) {
        _vo2max_evaluation = Agana.Math.parseFloat(vo2e);
    };

    this.getVO2maxEvaluation = function() {
        return _vo2max_evaluation;
    };

    this.getVO2maxAge = function() {
        try {
            validateGender();
            if (_gender == 'M') {
                return 60 - (0.55 * _age);
            } else {
                return 48 - (0.38 * _age);
            }
        } catch (err) {
            throw err;
        }
    };

    this.getAerobicDeficit = function(decimalNumbers) {
        decimalNumbers = decimalNumbers || 2;
        return (_vo2max_evaluation - this.getVO2maxAge()).toFixed(decimalNumbers);
    };

    this.getVO2Reservation = function() {
        return _vo2max_evaluation - _vo2_rest;
    };

    this.getVO2Target = function(decimalNumbers) {
        decimalNumbers = decimalNumbers || 2;
        var vo2_target = ((this.getIntensityWorkPercentage()/100) * this.getVO2Reservation()) + this.getVO2Rest();
        return vo2_target.toFixed(decimalNumbers);
    }

    this.getMET = function(decimalNumbers) {
        decimalNumbers = decimalNumbers || 2;
        var met = this.getVO2Target() / this.getVO2Rest();
        return met.toFixed(decimalNumbers);
    }

    this.getCaloricExpenditure = function(decimalNumbers) {
        decimalNumbers = decimalNumbers || 2;
        var calexp = (this.getWeight() * 300) / 70;
        return calexp.toFixed(decimalNumbers);
    }

    this.getKCal_min = function(decimalNumbers) {
        decimalNumbers = decimalNumbers || 2;
        var kcalmin = (this.getMET() * this.getVO2Rest() * this.getWeight()) / 200;
        return kcalmin.toFixed(decimalNumbers);
    }

    this.getActivityTimeByCalorieDemand = function(decimalNumbers) {
        decimalNumbers = decimalNumbers || 2;
        var acttime = this.getCaloricExpenditure() / this.getKCal_min();
        return acttime.toFixed(decimalNumbers);
    }

    this.getDistanceToGo = function() {
        var distance = ((this.getMET() * 1000) / 60) * this.getActivityTimeByCalorieDemand();
        return Math.round(distance);
    }

    this.getSpeedKm_h = function(decimalNumbers) {
        decimalNumbers = decimalNumbers || 2;
        var speed_km = ((this.getDistanceToGo() / this.getActivityTimeByCalorieDemand()) * 60) / 1000;
        return speed_km.toFixed(decimalNumbers);
    }
 
    this.getHeartRateMax = function(variation) {
        // FC desvio padrão até 25 anos é de +- 10 BPM, acima de 25 +- 12
        var v = 12;
        if (this.getAge() <= 25) {
            v = 10;
        }
        variation = variation || v;
        var max = 220 - this.getAge();
        return {
            'target':   max,
            'minus' :   max - variation,
            'max'   :   max + variation
        };
    }
    
    this.getHeartRateReservation = function(variation) {
        variation = variation || 12;
        var hrr = this.getHeartRateMax().target - this.getHeartRateRest();
        return {
            'target':   hrr,
            'minus' :   hrr - variation,
            'max'   :   hrr + variation
        };
    }
    
    this.getHeartRateTarget = function(fromIntensity, toIntensity, interval) {
        fromIntensity = fromIntensity || 55;
        toIntensity = toIntensity || 95;
        interval = interval || 5;
        var res = {};
        for (var intensity = fromIntensity; intensity <= toIntensity; intensity+=interval) {
            res[intensity] =  {
                'target': Math.round((this.getHeartRateReservation().target * (intensity/100)) + this.getHeartRateRest()),
                'minus' : Math.round((this.getHeartRateReservation().minus * (intensity/100)) + this.getHeartRateRest()),
                'max'   : Math.round((this.getHeartRateReservation().max * (intensity/100)) + this.getHeartRateRest())
            };
        }
        
        return res;
    }
    
    this.getWorkoutsNumber = function() {
        return Math.round((this.getAerobicDeficit() / 1.8) * 4);
    }
    
}