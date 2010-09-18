/**
 * Class: OpenLayers.DistBwPointAndLine
 *
 * Calculates intersection of a point with a line segment
 *
 */
OpenLayers.DistBwPointAndLine = OpenLayers.Class({

    /**
     *
     *
     */
    P1: null,
    P2: null,
    P3: null,
    intersectionPoint: null,
    distMinPoint:null,

    /**
     * array: [x,y]
     * LineString start and end point, point, intersection point
     */
    p1: [], //start point of line
    p2: [], //end point of line
    p3: [], //point
    p4: [], //orthogonal intersection point

    /**
     * scalar
     * denominator and nominator of u, u
     */
    denominator : 0,
    nominator :0,
    u: 0,

    /**
     * scalar
     * distance ortogonal p4-p1, p1-p3, p2-p3
     */
    distOrtho : 0,
    distP1 :0,
    distP2 :0,
    distMin :0,
    distMax :0,

    /**
     * Parameter : Geometry of a line and a point
     *
     */
    initialize: function(Line, Point) {

        this.P1 = Line.components[0];
        this.P2 = Line.components[1];
        this.P3 = Point;

        this.p1 = [Line.components[0].x, Line.components[0].y];
        this.p2 = [Line.components[1].x, Line.components[1].y];
        this.p3 = [Point.x, Point.y];

        this.denominator = Math.pow(Math.sqrt(Math.pow(this.p2[0]-this.p1[0],2) + Math.pow(this.p2[1]-this.p1[1],2)),2 );
        this.nominator   = (this.p3[0] - this.p1[0]) * (this.p2[0] - this.p1[0]) + (this.p3[1] - this.p1[1]) * (this.p2[1] - this.p1[1]);

        if(this.denominator==0)
        {   this.status = "coincidental"
            this.u = -999;
        }
        else
        {   this.u = this.nominator / this.denominator;
            if(this.u >=0 && this.u <= 1)
                this.status = "orthogonal";
            else
                this.status = "oblique";
        }
        this.intersection();
        this.distance();
    },

    /**
     * Method: intersection
     * Calculate intersection point
     * Return : OpenLayers.Point
     */
    intersection: function()
    {
        var x = this.p1[0] + this.u * (this.p2[0] - this.p1[0]);
        var y = this.p1[1] + this.u * (this.p2[1] - this.p1[1]);

        this.p4 = [x, y];

        this.intersectionPoint = new OpenLayers.Geometry.Point(x,y);
    },

    distance: function()
    {
        var x = this.p1[0] + this.u * (this.p2[0] - this.p1[0]);
        var y = this.p1[1] + this.u * (this.p2[1] - this.p1[1]);

        this.p4 = [x, y];

        this.distOrtho = Math.sqrt(Math.pow((this.p4[0] - this.p3[0]),2) + Math.pow((this.p4[1] - this.p3[1]),2));
        this.distP1    = Math.sqrt(Math.pow((this.p1[0] - this.p3[0]),2) + Math.pow((this.p1[1] - this.p3[1]),2));
        this.distP2    = Math.sqrt(Math.pow((this.p2[0] - this.p3[0]),2) + Math.pow((this.p2[1] - this.p3[1]),2));

        if(this.u>=0 && this.u<=1)
        {   this.distMin = this.distOrtho;
            this.distMinPoint = this.intersectionPoint;
        }
        else
        {   if(this.distP1 <= this.distP2)
            {   this.distMin = this.distP1;
                this.distMinPoint = this.P1;
            }
            else
            {   this.distMin = this.distP2;
                this.distMinPoint = this.P2;
            }
        }
        this.distMax = Math.max(Math.max(this.distOrtho, this.distP1), this.distP2);
    },

    CLASS_NAME: "OpenLayers.DistBwPointAndLine"
});
